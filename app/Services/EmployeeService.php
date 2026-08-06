<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class EmployeeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        Log::info('✅ Fetching all employees from service');
        return Employee::all();
    }

    public function create(array $data)
    {
        Log::info('✅ Creating employee from service');
        return Employee::create($data);
    }

    public function getById($id)
    {
        Log::info('✅ Fetching employee from service: ' . $id);
        return Employee::findOrFail($id);
    }

    public function update($id, array $data)
    {
        Log::info('✅ Updating employee from service: ' . $id);
        $employee = Employee::findOrFail($id);
        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        Log::info('✅ Deleting employee from service: ' . $id);
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return true;
    }
}
