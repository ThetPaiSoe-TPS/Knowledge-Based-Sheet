<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'user_id',
        'original_name',
        'file_path',
        'thumbnail_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
