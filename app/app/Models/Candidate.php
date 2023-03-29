<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Candidate extends Model
{
    use HasFactory;

    public const HIRED_STATUS = 'hired';
    public const CONTACTED_STATUS = 'contacted';

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_candidate')->withPivot('status')->withTimestamps();
    }
}
