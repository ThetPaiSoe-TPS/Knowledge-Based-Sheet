<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee') ?? null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employeeId,
            'department' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0|decimal:0,2',
            'status' => 'sometimes|string|in:active,inactive,terminated',
            'role' => 'sometimes|string|in:employee,manager,admin',
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'Employee name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email',
            'email.unique' => 'This email is already registered',
            'department.required' => 'Department is required',
            'salary.required' => 'Salary is required',
            'salary.numeric' => 'Salary must be a number',
            'status.in' => 'Status must be active, inactive, or terminated',
            'role.in' => 'Role must be employee, manager, or admin',
        ];
    }
}
