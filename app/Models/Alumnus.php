<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumnus extends Model
{
    protected $fillable = [
        'name',
        'graduation_year',
        'university',
        'country',
        'major',
        'profession',
        'testimony',
        'photo',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'graduation_year' => 'integer',
    ];
}
