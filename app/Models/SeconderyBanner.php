<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeconderyBanner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link',
        'position',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}