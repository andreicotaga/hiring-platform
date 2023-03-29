<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatePostRequest;
use App\Service\CandidateService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class CandidateController extends Controller
{
    public function __construct(
        private readonly CandidateService $candidateService,
    ) {
    }

    public function index(): Factory|View|Application
    {
        $candidates = $this->candidateService->getAllCandidates();

        return view('candidates.index', compact('candidates'));
    }

    public function contact(CandidatePostRequest $request): JsonResponse
    {
        $candidate = $this->candidateService->contactCandidate($request->candidate_id);

        return new JsonResponse(['data' => $candidate]);
    }

    public function hire(CandidatePostRequest $request): JsonResponse
    {
        $candidate = $this->candidateService->hireCandidate($request->candidate_id);

        return new JsonResponse(['data' => $candidate]);
    }
}
