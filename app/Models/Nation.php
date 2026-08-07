<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    protected $fillable = [
        'name',
        'code',
        'contitent',
        'population'
    ];

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function articles()
    {
        return $this->hasManyThrough(Article::class, Author::class, 'nation_id', 'author_id', 'id', 'id');
    }

    public function publishedArticles()
    {
        return $this->hasManyThrough(
            Article::class,
            Author::class,
            'nation_id',
            'author_id',
            'id',
            'id'
        )->where('is_published', true);
    }

    public function getArticleCountAttribute()
    {
        return $this->articles()->count();
    }
}
