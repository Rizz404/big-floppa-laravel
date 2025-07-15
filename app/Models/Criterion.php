<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'type',
        'description'
    ];

    public function breedScores()
    {
        return $this->hasMany(BreedScore::class);
    }
    public function sessionCriteriaWeights()
    {
        return $this->hasMany(SessionCriteriaWeight::class);
    }
}
