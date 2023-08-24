<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'title',
        'content',
        'category',
        'source',
        'urlToImage',
        'url',
        'publishedAt',
    ];

    protected $casts = [
        "author" => 'string',
        'title' => 'string',
        'content' => 'string',
        'category' => 'string',
        'source' => 'string',
        'urlToImage' => 'array',
        'url' => 'string',
        'publishedAt' => 'string',
    ];
}
