<?php declare(strict_types=1);

namespace App\Service;

use App\Models\Company;

class CompanyService
{
    public function getCompanyById(int $id): Company
    {
        return Company::find($id);
    }
}