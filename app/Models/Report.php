<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'total_orders',
        'total_revenue',
        'status',
        'completed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
