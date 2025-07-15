<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreedScore extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'breed_id',
        'criterion_id',
        'score'
    ];

    public function breed()
    {
        return $this->belongsTo(BreedScore::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criterion::class);
    }
}
