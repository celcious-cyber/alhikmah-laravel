<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $fillable = [
        'type', 'name', 'tagline', 'description', 'background_image', 'history',
        'head_name', 'head_title', 'thumbnail', 'head_photo',
        'npsn', 'nss', 'accreditation', 'accreditation_year',
        'operational_permit', 'permit_date', 'permit_issuer',
        'features', 'subjects', 'achievements', 'gallery',
        'total_students', 'total_teachers', 'year_established', 'order', 'legalities'
    ];

    protected $casts = [
        'features'         => 'array',
        'subjects'         => 'array',
        'achievements'     => 'array',
        'gallery'          => 'array',
        'background_image' => 'array',
        'legalities'       => 'array',
    ];
}
