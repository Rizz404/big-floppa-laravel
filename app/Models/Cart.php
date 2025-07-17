<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory, HasUlids;

    public function getCachedItemsCount(): int
    {
        // Buat kunci cache yang unik untuk setiap user
        $cacheKey = 'cart_count_user_' . $this->user_id;

        // Simpan hasil ke cache selama 15 menit
        return Cache::remember($cacheKey, now()->addMinutes(15), function () {
            // Fungsi ini hanya akan berjalan jika data tidak ada di cache
            return $this->items()->count();
        });
    }

    /**
     * Menghapus cache jumlah item untuk user ini.
     */
    public function forgetItemsCountCache(): void
    {
        $cacheKey = 'cart_count_user_' . $this->user_id;
        Cache::forget($cacheKey);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
