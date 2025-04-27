<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'detail',
        'news_date',
        'image'
    ];

    protected $casts = [
        'news_date' => 'datetime',
    ];
}

