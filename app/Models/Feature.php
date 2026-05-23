<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['title_id', 'desc_id', 'title_en', 'desc_en', 'icon', 'order'];
}
