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
        'evaluation_session_id',
        'breed_id',
        'final_score',
        'rank',
    ];

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }
}
