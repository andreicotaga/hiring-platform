<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Service\CompanyService;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService,
    ) {
    }

    public function index(): JsonResponse
    {
        $coins = $this->companyService->getCompanyById(Company::DEFAULT_COMPANY_ID)->wallet()->first()->coins;

        return new JsonResponse(compact('coins'));
    }
}