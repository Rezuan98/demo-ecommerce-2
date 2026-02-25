<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialBanner extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}