<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'thumbnail',
        'video_url',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Add a method to safely check for thumbnail
    public function hasThumbnail()
    {
        return !empty($this->thumbnail);
    }
}