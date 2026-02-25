<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_amount',
        'min_order_amount',
        'max_uses',
        'used_count',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
        'discount_amount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
    ];

    /**
     * Calculate discount for a given subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'fixed') {
            return min($this->discount_amount, $subtotal);
        }

        // percentage
        return round(($subtotal * $this->discount_amount) / 100, 2);
    }

    /**
     * Check if the coupon is currently valid.
     */
    public function isValid(float $subtotal = 0): bool
    {
        if (!$this->status) {
            return false;
        }

        $today = now()->startOfDay();

        if ($today->lt($this->start_date) || $today->gt($this->end_date)) {
            return false;
        }

        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }

        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return false;
        }

        return true;
    }
}
