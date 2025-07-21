<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Listing extends Model
{
    use HasFactory, HasUlids, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'gender',
        'birth_date',
        'price',
        'status',
        'is_vaccinated',
        'is_dewormed',
        'seller_id',
        'breed_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_vaccinated' => 'boolean',
        'is_dewormed' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeApplyFilters(Builder $query, array $filters): Builder
    {
        // Filter Pencarian
        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where('title', 'like', $searchTerm);
        }

        // Filter Gender
        if (!empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        // Filter Rentang Harga
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Filter Status Kesehatan (memeriksa jika '0' atau '1' dikirim)
        if (isset($filters['vaccinated']) && $filters['vaccinated'] !== '') {
            $query->where('is_vaccinated', (bool) $filters['vaccinated']);
        }
        if (isset($filters['dewormed']) && $filters['dewormed'] !== '') {
            $query->where('is_dewormed', (bool) $filters['dewormed']);
        }

        // Sorting
        $sortBy = $filters['sort'] ?? 'created_at';
        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', 'asc'); // Harga terendah ke tertinggi
                break;
            case 'birth_date':
                $query->orderBy('birth_date', 'desc'); // Usia termuda dulu
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', 'desc'); // Iklan terbaru dulu
                break;
        }

        return $query;
    }

    public function age(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->birth_date)->age,
        );
    }

    // Relasi
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function primaryPhoto(): HasOne
    {
        return $this->hasOne(ListingPhoto::class)
            ->where('is_primary', true)
            ->latest();
    }

    public function photos()
    {
        return $this->hasMany(ListingPhoto::class);
    }
}
