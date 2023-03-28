<?php

namespace App\Http\Controllers;

use App\Service\CompanyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    const DEFAULT_COMPANY_ID = 1;

    public function __construct(
        private readonly CompanyService $companyService,
    ) {
    }

    public function index(): Factory|View|Application
    {
        $coins = $this->companyService->getCompanyById(self::DEFAULT_COMPANY_ID)->wallet()->coins;

        return view('candidates.index', compact('coins'));
    }
}