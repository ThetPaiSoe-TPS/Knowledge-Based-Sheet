<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'city',
        'country',
        'balance',
        'is_active',
        'last_purchase_at'
    ];
}
