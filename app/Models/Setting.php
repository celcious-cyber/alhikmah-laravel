<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'Settings';

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = 'updatedAt';
}
