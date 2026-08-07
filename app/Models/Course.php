<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'code', 'credits'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('enrolled_at', 'grade')->withTimestamps();
        
    }
    

}
