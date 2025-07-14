<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecommendationRequest;
use App\Models\Criterion;
use App\Models\EvaluationSession;
use App\Models\SessionCriteriaWeight;
use App\Models\SessionFinalRanking;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RecommendationController extends Controller
{
    public function index(EvaluationSession $session)
    {
        $rankings = SessionFinalRanking::where('session_id', $session->id)
            ->with('breed')
            ->orderBy('rank', 'asc')
            ->get();

        return view('pages.user.recommendation.index')
            ->with('rankings', $rankings);
    }

    public function create()
    {
        $criteria = Criterion::all();

        return view('pages.user.recommendation.create')
            ->with('criteria', $criteria);
    }


    public function store(RecommendationRequest $request, TopsisService $topsisService)
    {
        $validatedWeights = $request->validated('weights');

        // 1. Hitung total dari semua bobot yang diberikan pengguna (skala 1-10)
        $totalWeight = array_sum($validatedWeights);

        // Mencegah pembagian dengan nol jika semua slider diset ke 0 (walaupun min=1)
        if ($totalWeight === 0) {
            // Jika total 0, anggap semua kriteria sama penting
            $count = count($validatedWeights);
            $normalizedWeights = array_fill_keys(array_keys($validatedWeights), 1 / $count);
        } else {
            // 2. Normalisasi setiap bobot
            $normalizedWeights = [];
            foreach ($validatedWeights as $criterionId => $weight) {
                $normalizedWeights[$criterionId] = $weight / $totalWeight;
            }
        }

        $session = $this->getSession($request);

        // 3. Simpan bobot yang sudah dinormalisasi ke database
        foreach ($normalizedWeights as $criterionId => $weight) {
            SessionCriteriaWeight::updateOrCreate(
                ['session_id' => $session->id, 'criterion_id' => $criterionId],
                ['weight' => $weight] // Bobot sudah ternormalisasi (misal: 0.25)
            );
        }

        // TopsisService akan bekerja dengan bobot yang sudah benar
        $topsisService->calculate($session);

        $redirect = redirect()->route('recommendations.index', $session);

        if (!cookie('guest_token') && !$session->user_id) {
            return $redirect->withCookie(cookie('guest_token', $session->guest_token, 60 * 24 * 30));
        }

        return $redirect;
    }

    private function getSession(Request $request): EvaluationSession
    {
        if (Auth::check()) {
            return EvaluationSession::create(['user_id' => Auth::id()]);
        }

        $guestToken = $request->cookie('guest_token');
        if ($guestToken) {
            // * Gunakan sesi guest yang ada, atau buat baru jika tidak valid
            return EvaluationSession::firstOrCreate(['guest_token' => $guestToken]);
        }

        // * Buat sesi baru untuk guest baru
        return EvaluationSession::create(['guest_token' => Str::random(40)]);
    }
}
