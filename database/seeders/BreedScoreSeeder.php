<?php

namespace Database\Seeders;

use App\Models\Breed;
use App\Models\BreedScore;
use App\Models\Criterion;
use Illuminate\Database\Seeder;

class BreedScoreSeeder extends Seeder
{
    public function run(): void
    {
        $breeds = Breed::all();
        $criteria = Criterion::all();

        foreach ($breeds as $breed) {
            foreach ($criteria as $criterion) {
                // * Buat skor acak untuk setiap pasangan ras dan kriteria
                BreedScore::updateOrCreate(
                    ['breed_id' => $breed->id, 'criterion_id' => $criterion->id],
                    ['score' => rand(30, 95)] // * Skor acak antara 30 s/d 95
                );
            }
        }
    }
}
