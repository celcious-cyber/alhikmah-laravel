<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'Gallery';

    protected $fillable = [
        'imageUrl',
        'caption',
        'category',
        'order',
        'author_id',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = null;

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
