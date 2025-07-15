<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'origin_country',
        'description',
        'photo_url'
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function breedScores()
    {
        return $this->hasMany(BreedScore::class);
    }

    public function sessionFinalRankings()
    {
        return $this->hasMany(SessionFinalRanking::class);
    }
}
