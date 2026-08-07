<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'content',
        'category',
        'views',
        'is_published',
        'published_at'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function Nation()
    {
        return $this->hasOneThrough(
            Nation::class,
            Author::class,
            'id',
            'id',
            'nation_id',
            'author_id',
        );
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }
}
