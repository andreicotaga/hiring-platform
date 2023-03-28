<?php

namespace App\Service;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;

class CandidateService
{
    public function getAllCandidates(): Collection
    {
        return Candidate::all();
    }
}