<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionFinalRanking extends Model
{
    /** @use HasFactory<\Database\Factories\SessionFinalRankingFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'session_id',
        'breed_id',
        'final_score',
        'rank',
    ];
}
