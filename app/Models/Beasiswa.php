<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    protected $table = 'beasiswa';

    protected $guarded = ['id'];

    protected $casts = [
        'verified' => 'boolean',
    ];
}
