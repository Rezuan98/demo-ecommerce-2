<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'subtotal',
        'shipping_charge',
        'tax',
        'coupon_code',
        'discount_amount',
        'total',
        'payment_method',
        'transaction_id',
        'payment_status',
        'order_status',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'order_notes'
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('ymd');
        $lastOrder = self::latest()->first();

        if (!$lastOrder) {
            $number = '0001';
        } else {
            $lastNumber = substr($lastOrder->order_number, -4);
            $number = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . $date . $number;
    }

    // Order status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge bg-warning',
            'processing' => 'badge bg-info',
            'shipped' => 'badge bg-primary',
            'delivered' => 'badge bg-success',
            'cancelled' => 'badge bg-danger'
        ];

        return '<span class="' . ($badges[$this->order_status] ?? 'badge bg-secondary') . '">'
            . ucfirst($this->order_status) .
            '</span>';
    }

    // Payment status badge
    public function getPaymentBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge bg-warning',
            'paid' => 'badge bg-success',
            'failed' => 'badge bg-danger'
        ];

        return '<span class="' . ($badges[$this->payment_status] ?? 'badge bg-secondary') . '">'
            . ucfirst($this->payment_status) .
            '</span>';
    }

    // Scope for filtering orders
    public function scopeFilter($query, $filters)
    {
        return $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('order_number', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('order_status', $status);
        })->when($filters['payment_status'] ?? false, function ($query, $paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        });
    }


    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
