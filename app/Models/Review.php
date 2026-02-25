<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'embed_code',
        'all_review_link',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Scope for active reviews
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Scope for ordered reviews
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')
                     ->orderBy('created_at', 'desc');
    }
}
