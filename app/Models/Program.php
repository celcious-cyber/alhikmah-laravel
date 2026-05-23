<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'Programs';

    protected $fillable = [
        'title',
        'category',
        'description',
        'imageUrl',
        'order',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = null;
}
