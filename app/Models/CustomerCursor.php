<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCursor extends Model
{
    protected $fillable = [
        'name', 'email', 'city', 'country', 'balance', 'is_active'
    ];

    public function orderscursor()
    {
        return $this->hasMany(OrderCursor::class);
    }
}
