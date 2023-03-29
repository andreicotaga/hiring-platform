<?php

namespace App\Service;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CandidateService
{
    public function getAllCandidates(): Collection
    {
        return Candidate::with('companies')->get();
    }

    public function getCandidateById(int $id): ?Candidate
    {
        return Candidate::find($id);
    }

    public function contactCandidate(int $candidateId): ?Candidate
    {
        $candidate = $this->getCandidateById($candidateId);

        if ($candidate->companies()->exists()) {
            throw new BadRequestHttpException('Given candidate was already contacted or hired.');
        }

        $candidate->companies()->attach(Company::DEFAULT_COMPANY_ID, ['status' => Candidate::CONTACTED_STATUS]);

        $currentCompanyCoinsAmount = $candidate->companies()->first()->wallet()->first()->coins;

        if ($currentCompanyCoinsAmount <= Wallet::CONTACT_COINS_AMOUNT) {
            throw new BadRequestHttpException('There are no more coins available on your account.');
        }

        $candidate->companies()->first()->wallet()->first()->update(['coins' => $currentCompanyCoinsAmount - Wallet::CONTACT_COINS_AMOUNT]);

        return $candidate;
    }

    public function hireCandidate(int $candidateId): ?Candidate
    {
        $candidate = $this->getCandidateById($candidateId);

        if ($candidate->companies()->wherePivot('status', Candidate::CONTACTED_STATUS)->doesntExist()) {
            throw new BadRequestHttpException('A candidate must be contacted in order to be hired.');
        }

        if ($candidate->companies()->wherePivot('status', Candidate::HIRED_STATUS)->exists()) {
            throw new BadRequestHttpException('Given candidate was already hired.');
        }

        $candidate->companies()->attach(Company::DEFAULT_COMPANY_ID, ['status' => Candidate::HIRED_STATUS]);

        $currentCompanyCoinsAmount = $candidate->companies()->first()->wallet()->first()->coins;

        $candidate->companies()->first()->wallet()->first()->update(['coins' => $currentCompanyCoinsAmount + Wallet::CONTACT_COINS_AMOUNT]);

        return $candidate;
    }
}