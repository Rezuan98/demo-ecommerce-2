<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'link',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get active popup
     */
    public static function getActivePopup()
    {
        return self::where('status', true)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}