<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCriteriaWeight extends Model
{
    /** @use HasFactory<\Database\Factories\SessionCriteriaWeightFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'evaluation_session_id',
        'criterion_id ',
        'weight'
    ];
}
