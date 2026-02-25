<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $fillable = [
        'location_type',
        'charge',
        'status'
    ];

    protected $casts = [
        'charge' => 'decimal:2',
        'status' => 'boolean'
    ];
}