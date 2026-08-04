<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class PostAutho extends Model
{
    protected $table = 'post_authos';
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'is_published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
