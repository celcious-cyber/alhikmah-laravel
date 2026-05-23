<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    protected $fillable = ['news_id', 'name', 'email', 'content'];

    protected $appends = ['formatted_date'];

    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->locale('id')->translatedFormat('d F Y');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
