<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory, HasUlids;

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
