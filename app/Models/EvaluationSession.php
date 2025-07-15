<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationSession extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "guest_token",
        "user_id",
        "session_name",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
