<?php

namespace App\Models;

use App\Services\Crawler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $hidden = ['source_article'];

    protected $guarded = [];

    protected $casts = [
        'formatted_article' => 'array',
        'source_article' => 'array',
    ];
}
