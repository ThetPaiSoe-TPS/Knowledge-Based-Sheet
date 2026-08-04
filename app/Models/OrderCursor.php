<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCursor extends Model
{
    protected $fillable = [
        'customer_id',
        'total',
        'status',
        'payment_method',
        'ordered_at',
        'shipped_at',
        'delivered_at'
    ];

    public function customercursor()
    {
        return $this->belongsTo(CustomerCursor::class);
    }
}
