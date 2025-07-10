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
}
