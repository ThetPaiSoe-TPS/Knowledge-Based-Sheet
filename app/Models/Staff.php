<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'last_name',
        'email',
        'position',
        'salary',
        'hire_date',
        'skill_set',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hire_date' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function activeProjects()
    {   
        return $this->projects()->where('is_completed', false);
    }

    public function completedProjects()
    {
        return $this->projects()->where('is_completed', true);
    }

    public function projectsByStatus($status)
    {
        return $this->projects()->where('status', $status);
    }








}
