<?php

namespace App\Services;

use App\Models\Breed;
use App\Models\Criterion;
use App\Models\EvaluationSession;
use App\Models\SessionFinalRanking;

class TopsisService
{

  public function calculate(EvaluationSession $evaluationSession): void
  {
    // * Ambil data yang dibutuhkan
    $weights = $evaluationSession->sessionCriteriaWeights()->pluck('weight', 'criterion_id');
    $criteria = Criterion::find($weights->keys());
    $breeds = Breed::with('breedScores')->get();

    // * Buat matriks keputusan dari data yang ada
    $matrix = $this->buildDecisionMatrix($breeds, $criteria);
    $breedIds = $breeds->pluck('id')->toArray();
    $criteriaIds = $criteria->pluck('id')->toArray();

    // * 1. Normalisasi Matriks
    $normalizedMatrix = $this->normalizeMatrix($matrix, $breedIds, $criteriaIds);

    // * 2. Buat Matriks Terbobot
    $weightedMatrix = $this->applyWeights($normalizedMatrix, $weights, $breedIds, $criteriaIds);

    // * 3. Tentukan Solusi Ideal Positif (A+) & Negatif (A-)
    $criteriaTypes = $criteria->pluck('type', 'id');
    [$idealPositive, $idealNegative] = $this->findIdealSolutions($weightedMatrix, $criteriaIds, $criteriaTypes);

    // * 4. Hitung Jarak ke Solusi Ideal (D+ dan D-)
    [$distancePositive, $distanceNegative] = $this->calculateDistances($weightedMatrix, $idealPositive, $idealNegative, $breedIds, $criteriaIds);

    // * 5. Hitung Nilai Preferensi (V) dan simpan hasil
    $this->calculateAndSaveRankings($evaluationSession, $distancePositive, $distanceNegative, $breedIds);
  }

  private function buildDecisionMatrix($breeds, $criteria): array
  {
    $matrix = [];
    foreach ($breeds as $breed) {
      foreach ($criteria as $criterion) {
        // * Ambil skor dari relasi 'scores' yang sudah di-load
        $score = $breed->breedScores()->firstWhere('criterion_id', $criterion->id);
        $matrix[$breed->id][$criterion->id] = $score ? $score->score : 0;
      }
    }
    return $matrix;
  }

  private function normalizeMatrix(array $matrix, array $breedIds, array $criteriaIds): array
  {
    $normalizedMatrix = [];
    foreach ($criteriaIds as $critId) {
      $sumOfSquares = 0;
      foreach ($breedIds as $breedId) {
        $sumOfSquares += pow($matrix[$breedId][$critId], 2);
      }
      $divider = sqrt($sumOfSquares);

      if ($divider == 0) continue;

      foreach ($breedIds as $breedId) {
        $normalizedMatrix[$breedId][$critId] = $matrix[$breedId][$critId] / $divider;
      }
    }
    return $normalizedMatrix;
  }

  private function applyWeights(array $matrix, $weights, array $breedIds, array $criteriaIds): array
  {
    $weightedMatrix = [];
    foreach ($breedIds as $breedId) {
      foreach ($criteriaIds as $critId) {
        $weightedMatrix[$breedId][$critId] = $matrix[$breedId][$critId] * $weights[$critId];
      }
    }
    return $weightedMatrix;
  }

  private function findIdealSolutions(array $matrix, array $criteriaIds, $criteriaTypes): array
  {
    $idealPositive = [];
    $idealNegative = [];
    foreach ($criteriaIds as $critId) {
      $columnValues = array_column($matrix, $critId);
      if (empty($columnValues)) continue;

      if ($criteriaTypes[$critId] === 'benefit') {
        $idealPositive[$critId] = max($columnValues);
        $idealNegative[$critId] = min($columnValues);
      } else { // 'cost'
        $idealPositive[$critId] = min($columnValues);
        $idealNegative[$critId] = max($columnValues);
      }
    }
    return [$idealPositive, $idealNegative];
  }

  private function calculateDistances(array $matrix, array $idealPositive, array $idealNegative, array $breedIds, array $criteriaIds): array
  {
    $distancePositive = [];
    $distanceNegative = [];
    foreach ($breedIds as $breedId) {
      $sumSqrPos = 0;
      $sumSqrNeg = 0;
      foreach ($criteriaIds as $critId) {
        $sumSqrPos += pow($matrix[$breedId][$critId] - $idealPositive[$critId], 2);
        $sumSqrNeg += pow($matrix[$breedId][$critId] - $idealNegative[$critId], 2);
      }
      $distancePositive[$breedId] = sqrt($sumSqrPos);
      $distanceNegative[$breedId] = sqrt($sumSqrNeg);
    }
    return [$distancePositive, $distanceNegative];
  }

  private function calculateAndSaveRankings(EvaluationSession $evaluationSession, array $distPos, array $distNeg, array $breedIds): void
  {
    $finalScores = [];
    foreach ($breedIds as $breedId) {
      $denominator = $distPos[$breedId] + $distNeg[$breedId];
      $finalScores[$breedId] = ($denominator == 0) ? 0 : $distNeg[$breedId] / $denominator;
    }

    arsort($finalScores);
    $rank = 1;
    foreach ($finalScores as $breedId => $score) {
      SessionFinalRanking::updateOrCreate(
        ['evaluation_session_id' => $evaluationSession->id, 'breed_id' => $breedId],
        ['final_score' => $score, 'rank' => $rank++]
      );
    }
  }
}
