<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create active employees
        Employee::create([
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'department' => 'Engineering',
            'salary' => 75000,
            'status' => 'active',
            'role' => 'manager'
        ]);

        Employee::create([
            'name' => 'Jane Smith',
            'email' => 'jane@test.com',
            'department' => 'Marketing',
            'salary' => 65000,
            'status' => 'active',
            'role' => 'employee'
        ]);

        Employee::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@test.com',
            'department' => 'Engineering',
            'salary' => 70000,
            'status' => 'active',
            'role' => 'employee'
        ]);

        // Create inactive employees
        Employee::create([
            'name' => 'Alice Brown',
            'email' => 'alice@test.com',
            'department' => 'HR',
            'salary' => 55000,
            'status' => 'inactive',
            'role' => 'employee'
        ]);

        Employee::create([
            'name' => 'Charlie Wilson',
            'email' => 'charlie@test.com',
            'department' => 'Finance',
            'salary' => 60000,
            'status' => 'terminated',
            'role' => 'employee'
        ]);
    }
}
