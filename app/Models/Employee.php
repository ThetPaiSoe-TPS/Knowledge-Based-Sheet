<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department',
        'salary',
        'status',
        'role'
    ];


    /**
     * Accessor: Get formatted salary with currency
     * Usage: $employee->formatted_salary
     * Output: "$75,000.00"
     */
    public function getFormattedSalaryAttribute()
    {
        if ($this->salary === null) {
            return null;  // or return '$0.00'; if you prefer a default
        }
        return '$' . number_format($this->salary, 2);
    }

    /**
     * Accessor: Get annual salary (salary * 12)
     * Usage: $employee->annual_salary
     * Output: 900000
     */
    public function getAnnualSalaryAttribute()
    {
        return $this->salary * 12;
    }

    /**
     * Accessor: Get salary with currency symbol
     * Usage: $employee->salary_with_currency
     * Output: "75,000.00 USD"
     */
    public function getSalaryWithCurrencyAttribute()
    {
        return number_format($this->salary, 2, '.', ',') . ' USD';
    }

    /**
     * Accessor: Get email domain
     * Usage: $employee->email_domain
     * Output: "gmail.com"
     */
    public function getEmailDomainAttribute()
    {
        return substr(strrchr($this->email, "@"), 1);
    }

    /**
     * Accessor: Get status badge HTML
     * Usage: $employee->status_badge
     * Output: '<span class="badge bg-success">Active</span>'
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-danger">Inactive</span>',
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'terminated' => '<span class="badge bg-dark">Terminated</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Accessor: Get status color
     * Usage: $employee->status_color
     * Output: "success"
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'active' => 'success',
            'inactive' => 'danger',
            'pending' => 'warning',
            'terminated' => 'dark',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Accessor: Get role badge HTML
     * Usage: $employee->role_badge
     * Output: '<span class="badge bg-primary">Employee</span>'
     */
    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => '<span class="badge bg-danger">Admin</span>',
            'manager' => '<span class="badge bg-primary">Manager</span>',
            'employee' => '<span class="badge bg-secondary">Employee</span>',
            'intern' => '<span class="badge bg-info">Intern</span>',
        ];

        return $badges[$this->role] ?? '<span class="badge bg-secondary">' . ucfirst($this->role) . '</span>';
    }

    /**
     * Accessor: Get role color
     * Usage: $employee->role_color
     * Output: "primary"
     */
    public function getRoleColorAttribute()
    {
        $colors = [
            'admin' => 'danger',
            'manager' => 'primary',
            'employee' => 'secondary',
            'intern' => 'info',
        ];

        return $colors[$this->role] ?? 'secondary';
    }

    /**
     * Accessor: Get employee initials
     * Usage: $employee->initials
     * Output: "JD"
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', trim($this->name));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 3);
    }

    /**
     * Accessor: Get first name
     * Usage: $employee->first_name
     * Output: "John"
     */
    public function getFirstNameAttribute()
    {
        $parts = explode(' ', trim($this->name));
        return $parts[0] ?? '';
    }

    /**
     * Accessor: Get last name
     * Usage: $employee->last_name
     * Output: "Doe"
     */
    public function getLastNameAttribute()
    {
        $parts = explode(' ', trim($this->name));
        return isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : '';
    }

    /**
     * Accessor: Get formatted created date
     * Usage: $employee->created_date
     * Output: "August 6, 2026"
     */
    public function getCreatedDateAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->format('F d, Y');
        }
        return null;
    }

    /**
     * Accessor: Get formatted created date time
     * Usage: $employee->created_datetime
     * Output: "August 6, 2026 2:30 PM"
     */
    public function getCreatedDatetimeAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->format('F d, Y g:i A');
        }
        return null;
    }

    /**
     * Accessor: Get time ago
     * Usage: $employee->created_ago
     * Output: "2 hours ago"
     */
    public function getCreatedAgoAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }
        return null;
    }

    /**
     * Accessor: Get updated date
     * Usage: $employee->updated_date
     * Output: "August 6, 2026"
     */
    public function getUpdatedDateAttribute()
    {
        if ($this->updated_at) {
            return $this->updated_at->format('F d, Y');
        }
        return null;
    }

    /**
     * Accessor: Get updated time ago
     * Usage: $employee->updated_ago
     * Output: "2 hours ago"
     */
    public function getUpdatedAgoAttribute()
    {
        if ($this->updated_at) {
            return $this->updated_at->diffForHumans();
        }
        return null;
    }

    /**
     * Accessor: Get salary range category
     * Usage: $employee->salary_range
     * Output: "Mid-Level"
     */
    public function getSalaryRangeAttribute()
    {
        if ($this->salary < 30000) {
            return 'Entry Level';
        } elseif ($this->salary < 50000) {
            return 'Junior';
        } elseif ($this->salary < 80000) {
            return 'Mid-Level';
        } elseif ($this->salary < 120000) {
            return 'Senior';
        } else {
            return 'Executive';
        }
    }

    /**
     * Accessor: Get department (formatted)
     * Usage: $employee->department_formatted
     * Output: "Engineering"
     */
    public function getDepartmentFormattedAttribute()
    {
        return ucwords(strtolower($this->department));
    }

    /**
     * Accessor: Get email (masked for privacy)
     * Usage: $employee->email_masked
     * Output: "j****e@test.com"
     */
    public function getEmailMaskedAttribute()
    {
        $email = $this->email;
        $parts = explode('@', $email);
        $username = $parts[0];

        if (strlen($username) <= 2) {
            $masked = $username[0] . '****' . $username[strlen($username) - 1];
        } else {
            $masked = $username[0] . str_repeat('*', strlen($username) - 2) . $username[strlen($username) - 1];
        }

        return $masked . '@' . $parts[1];
    }

    /**
     * Accessor: Check if employee is active
     * Usage: $employee->is_active
     * Output: true/false
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    /**
     * Accessor: Check if employee is admin
     * Usage: $employee->is_admin
     * Output: true/false
     */
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    /**
     * Accessor: Check if employee is manager
     * Usage: $employee->is_manager
     * Output: true/false
     */
    public function getIsManagerAttribute()
    {
        return $this->role === 'manager';
    }

    // ========================================
    // ============ MUTATORS =================
    // ========================================

    /**
     * Mutator: Set name (capitalize properly)
     * Usage: $employee->name = 'john doe'
     * Stores: 'John Doe'
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Mutator: Set email (lowercase and trim)
     * Usage: $employee->email = 'JOHN@TEST.COM'
     * Stores: 'john@test.com'
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    /**
     * Mutator: Set department (capitalize)
     * Usage: $employee->department = 'engineering'
     * Stores: 'Engineering'
     */
    public function setDepartmentAttribute($value)
    {
        $this->attributes['department'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Mutator: Set salary (ensure positive)
     * Usage: $employee->salary = -5000
     * Stores: 0
     */
    public function setSalaryAttribute($value)
    {
        $this->attributes['salary'] = max(0, (float)$value);
    }

    /**
     * Mutator: Set status (lowercase)
     * Usage: $employee->status = 'ACTIVE'
     * Stores: 'active'
     */
    public function setStatusAttribute($value)
    {
        $validStatuses = ['active', 'inactive', 'pending', 'terminated'];
        $status = strtolower(trim($value));
        $this->attributes['status'] = in_array($status, $validStatuses) ? $status : 'active';
    }

    /**
     * Mutator: Set role (lowercase)
     * Usage: $employee->role = 'ADMIN'
     * Stores: 'admin'
     */
    public function setRoleAttribute($value)
    {
        $validRoles = ['admin', 'manager', 'employee', 'intern'];
        $role = strtolower(trim($value));
        $this->attributes['role'] = in_array($role, $validRoles) ? $role : 'employee';
    }


    /**
     * The "booted" method of the model.
     * This adds the global scope to ALWAYS filter active employees.
     */
    protected static function booted()
    {
        // ✅ Global scope: Only show active employees by default
        static::addGlobalScope('active', function ($query) {
            $query->where('status', 'active');
        });
    }

    /**
     * ✅ LOCAL SCOPE: Get ALL employees (including inactive)
     * Removes the global scope temporarily
     */
    public static function getAllEmployees()
    {
        return static::withoutGlobalScope('active')->get();
    }

    /**
     * ✅ LOCAL SCOPE: Get only inactive employees
     */
    public static function getInactiveEmployees()
    {
        return static::withoutGlobalScope('active')
            ->where('status', '!=', 'active')
            ->get();
    }

    /**
     * ✅ LOCAL SCOPE: Get employee by ID (including inactive)
     */
    public static function findAny($id)
    {
        return static::withoutGlobalScope('active')->find($id);
    }

    /**
     * ✅ LOCAL SCOPE: Count all employees (including inactive)
     */
    public static function countAll()
    {
        return static::withoutGlobalScope('active')->count();
    }

    /**
     * ✅ LOCAL SCOPE: Count only inactive employees
     */
    public static function countInactive()
    {
        return static::withoutGlobalScope('active')
            ->where('status', '!=', 'active')
            ->count();
    }

    // ========== ✅ ADD THESE LOCAL SCOPES ==========

    /**
     * ✅ Local Scope: Active employees
     * Usage: Employee::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * ✅ Local Scope: Inactive employees
     * Usage: Employee::inactive()->get()
     */
    public function scopeInactive($query)
    {
        return $query->where('status', '!=', 'active');
    }

    /**
     * ✅ Local Scope: Engineering department
     * Usage: Employee::engineering()->get()
     */
    public function scopeEngineering($query)
    {
        return $query->where('department', 'Engineering');
    }

    /**
     * ✅ Local Scope: Marketing department
     * Usage: Employee::marketing()->get()
     */
    public function scopeMarketing($query)
    {
        return $query->where('department', 'Marketing');
    }

    /**
     * ✅ Local Scope: High salary (> 70000)
     * Usage: Employee::highSalary()->get()
     */
    public function scopeHighSalary($query)
    {
        return $query->where('salary', '>', 70000);
    }

    /**
     * ✅ Local Scope: By role
     * Usage: Employee::role('manager')->get()
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * ✅ Local Scope: Search by name or email
     * Usage: Employee::search('John')->get()
     */
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%");
    }

    /**
     * ✅ Local Scope: Salary between min and max
     * Usage: Employee::salaryBetween(50000, 80000)->get()
     */
    public function scopeSalaryBetween($query, $min, $max)
    {
        return $query->whereBetween('salary', [$min, $max]);
    }

    /**
     * ✅ Local Scope: Sort by column
     * Usage: Employee::sort('salary', 'desc')->get()
     */
    public function scopeSort($query, $column = 'created_at', $direction = 'desc')
    {
        return $query->orderBy($column, $direction);
    }

    /**
     * ✅ Local Scope: By department (dynamic)
     * Usage: Employee::department('HR')->get()
     */
    public function scopeDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}
