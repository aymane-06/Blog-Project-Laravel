<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    protected function user()
    {
        return $this->belongsTo(User::class);
    }
    protected function category()
    {
        return $this->belongsTo(Category::class);
    }
}
