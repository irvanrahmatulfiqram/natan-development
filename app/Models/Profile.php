<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'professional_title',
        'tagline',
        'location',
        'short_bio',
        'about',
        'email',
        'whatsapp',
        'github',
        'linkedin',
        'instagram',
        'tiktok',
        'availability_status',
    ];

    protected function casts(): array
    {
        return [
            'availability_status' => 'boolean',
        ];
    }
}
