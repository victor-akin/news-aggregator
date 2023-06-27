<?php

namespace App\Models;

use App\Services\Crawler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'id', 'source_id'];

    protected $guarded = [];

    protected $casts = [
        'formatted_article' => 'array',
        'source_article' => 'array',
    ];
}
