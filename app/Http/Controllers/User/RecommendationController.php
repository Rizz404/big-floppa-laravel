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

        // Passing data rankings ke view
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
        // ! gak perlu lagi
        // $validated = $request->validated();

        $validatedWeights = $request->validated('weights');

        $session = $this->getSession($request);

        // * Simpan ke db
        foreach ($validatedWeights as $criterionId => $weight) {
            SessionCriteriaWeight::updateOrCreate(
                ['session_id' => $session->id, 'criterion_id' => $criterionId],
                ['weight' => $weight / 100]
            );
        }

        // * Gak perlu new lagi soalnya udah pake provider
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
