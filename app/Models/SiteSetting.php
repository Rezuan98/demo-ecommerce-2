<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $casts = [
        'flat_discount_active' => 'boolean',
        'flat_discount_amount' => 'float',
    ];

    protected $fillable = [
        'site_name',
        'logo',
        'favicon',
        'phone',
        'email',
        'address',
        'footer_description',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'flat_discount_active',
        'flat_discount_type',
        'flat_discount_amount',
    ];
}
