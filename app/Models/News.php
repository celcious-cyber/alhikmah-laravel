<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'News';
    
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'isPublished',
        'views_count',
        'shares_count',
        'author_id',
    ];

    protected $casts = [
        'isPublished' => 'boolean',
    ];

    protected $appends = ['formatted_date'];

    public function getFormattedDateAttribute()
    {
        if (!$this->createdAt) {
            return '';
        }
        return \Carbon\Carbon::parse($this->createdAt)->locale('id')->translatedFormat('d F Y');
    }

    // Align with Prisma's CamelCase timestamp columns
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function comments()
    {
        return $this->hasMany(NewsComment::class, 'news_id')->orderBy('created_at', 'desc');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
