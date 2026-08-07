<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'release_year'
    ];

    public function actor()
    {
        return $this->belongsToMany(Actor::class)->withPivot('character_name', 'is_lead');
    }
}
