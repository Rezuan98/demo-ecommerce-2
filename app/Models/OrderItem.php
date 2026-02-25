<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'subtotal',
        'variant_size'
    ];

    // Define relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVarient::class, 'variant_id');
    }

    // Calculate subtotal
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
        });
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return '৳' . number_format($this->price, 2);
    }

    // Get formatted subtotal
    public function getFormattedSubtotalAttribute()
    {
        return '৳' . number_format($this->subtotal, 2);
    }

    // Get variant information
    public function getVariantInfoAttribute()
    {
        if ($this->variant_size) {
            return $this->variant_size;
        }
        return 'N/A';
    }
}
