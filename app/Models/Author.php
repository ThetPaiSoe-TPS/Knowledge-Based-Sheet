<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'nation_id', 'name', 'email', 'bio', 'birth_date'
    ];

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function publishedArticles()
    {
        return $this->articles()->where('is_published', true);
    }

    public function getTotalArticlesAttribute()
    {
        return $this->articles()->count();
    }
}
