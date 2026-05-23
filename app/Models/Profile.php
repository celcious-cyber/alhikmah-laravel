<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features'         => 'array',
        'subjects'         => 'array',
        'achievements'     => 'array',
        'gallery'          => 'array',
        'background_image' => 'array',
        'legalities'       => 'array',
    ];
}
