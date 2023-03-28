<?php

namespace App\Http\Controllers;

use App\Service\CandidateService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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

    public function contact()
    {
        // @todo
        // Your code goes here...
    }

    public function hire()
    {
        // @todo
        // Your code goes here...
    }
}
