<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function breedScores()
    {
        return $this->hasMany(BreedScore::class);
    }

    public function sessionFinalRankings()
    {
        return $this->hasMany(SessionFinalRanking::class);
    }

    public function scopeApplyFilters(Builder $query, array $filters): Builder
    {
        // * Search functionality by name or origin country
        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'ilike', $search)
                    ->orWhere('origin_country', 'ilike', $search);
            });
        }

        // * Filter by country
        if (!empty($filters['country'])) {
            $query->where('origin_country', $filters['country']);
        }

        // * Sorting logic
        $sortBy = $filters['sort'] ?? 'name';
        $sortOrder = $filters['order'] ?? 'asc';

        // * Whitelist columns to sort by for security
        $allowedSortColumns = ['name', 'origin_country', 'created_at', 'listings_count'];

        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query;
    }
}
