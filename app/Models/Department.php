<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name', 'code', 'location', 'manager_name', 
        'budget', 'type'
    ];

    public function staff()
    {
        return $this->hasMany::class();
    }

    public function projects()
    {
        return $this->hasOneThrough(Project::class, Staff::class, 'department_id', 'staff_id', 'id', 'id');
    }

    public function activeStaff()
    {
        return $this->staff()->where('is_active', true);
    }

    public function completedTasks()
    {
        return $this->projects()->where('is_completed', true);
    }

    public function highPriorityProjects()
    {
        return $this->projects()->where('priority', 'high');
    }

    public function getProjectCountAttribute()
    {
        return $this->projects()->count();
    }

    public function getTotalSalariesAttribute()
    {
        return $this->staff()->sum('salary');
    }
}
