<?php

namespace App\Models;

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
        // Debug log
        if (config('app.debug')) {
            logger('Applying filters:', $filters);
        }

        // Filter Gender
        if (!empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
            logger('Applied gender filter:', ['gender' => $filters['gender']]);
        }

        // Filter Kesehatan - untuk checkbox, cek apakah ada dan bernilai true
        // Filter Kesehatan - Gunakan null coalescing
        if ($filters['is_vaccinated'] ?? false) {
            $query->where('is_vaccinated', true);
            logger('Applied vaccinated filter');
        }

        if ($filters['is_dewormed'] ?? false) {
            $query->where('is_dewormed', true);
            logger('Applied dewormed filter');
        }

        // Filter Umur - berdasarkan birth_date
        if (!empty($filters['age_min']) && is_numeric($filters['age_min'])) {
            $maxBirthDate = now()->subYears($filters['age_min'])->endOfDay();
            $query->where('birth_date', '<=', $maxBirthDate);
            logger('Applied age_min filter:', ['age_min' => $filters['age_min'], 'max_birth_date' => $maxBirthDate]);
        }

        if (!empty($filters['age_max']) && is_numeric($filters['age_max'])) {
            $minBirthDate = now()->subYears($filters['age_max'] + 1)->startOfDay();
            $query->where('birth_date', '>=', $minBirthDate);
            logger('Applied age_max filter:', ['age_max' => $filters['age_max'], 'min_birth_date' => $minBirthDate]);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        // Pastikan kolom yang di-sort ada di database
        $allowedSortColumns = ['created_at', 'updated_at', 'title'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortDirection);
            logger('Applied sorting:', ['sort_by' => $sortBy, 'sort_direction' => $sortDirection]);
        } else {
            $query->orderBy('created_at', 'desc');
            logger('Applied default sorting');
        }

        return $query;
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
