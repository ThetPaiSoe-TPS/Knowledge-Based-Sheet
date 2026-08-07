<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = [
        'name', 'birth_date'
    ];

    public function movie()
    {
        return $this->belongsToMany(Movie::class)->withPivot('character_name', 'is_lead')->withTimestamps();
    }
}
