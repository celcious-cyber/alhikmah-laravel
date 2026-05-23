<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'Contact';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'isRead',
    ];

    protected $casts = [
        'isRead' => 'boolean',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = null;
}
