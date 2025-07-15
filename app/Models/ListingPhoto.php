<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingPhoto extends Model
{
    /** @use HasFactory<\Database\Factories\ListingPhotoFactory> */
    use HasFactory, HasUlids;

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
