<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    // Mass-assignment bypass for large dynamic forms
    protected $guarded = ['id'];

    protected $casts = [
        'verified' => 'boolean',
    ];
}
