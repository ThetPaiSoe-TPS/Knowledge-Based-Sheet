<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable= ['title','description', 'status', 'priority', 'due_date', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}


