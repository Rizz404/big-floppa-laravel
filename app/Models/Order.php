<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, HasUlids;

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['payment_status'] ?? null, function ($query, $status) {
            $query->whereHas('payment', fn($q) => $q->where('status', $status));
        });

        $query->when($filters['payment_method'] ?? null, function ($query, $method) {
            $query->whereHas('payment', fn($q) => $q->where('payment_method', $method));
        });

        return $query;
    }

    public function scopeSort(Builder $query, ?string $sortBy = 'created_at', ?string $direction = 'desc'): Builder
    {
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        if ($sortBy === 'payment_amount') {
            return $query->join('payments', 'orders.id', '=', 'payments.order_id')
                ->orderBy('payments.amount', $direction)
                ->select('orders.*'); // * Hindari kolom ambigu
        }

        $allowedSorts = ['created_at', 'total_amount'];
        if (in_array($sortBy, $allowedSorts)) {
            return $query->orderBy($sortBy, $direction);
        }

        return $query->orderBy('created_at', $direction); // * Default sort
    }

    // * Relasi
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
