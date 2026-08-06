<?php

namespace App\Http\Controllers;

use App\Events\EmployeeCreated;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected EmployeeService $employeeService;

    // ✅ Laravel automatically injects the service!
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }


    public function index()
    {
        $employees = $this->employeeService->getAll();

        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:employees,email',
        //     'department' => 'required|string|max:255',
        //     'phone' => 'nullable|string|max:20',
        // ]);

        // if ($validator->failed()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => $validator->errors(),
        //     ], 422);
        // }

        $employee = Employee::create($request->validated());
        event(new EmployeeCreated($employee));

        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = $this->employeeService()->getById($id);

        if (!$employee) {
            return response([
                'status' => 'error',
                'message' => 'Employee not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $employee,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'success' => 'error',
                'message' => 'Employee not found'
            ], 404);
        }

        // $validator = Validator::make($request->all(), [
        //     'name' => 'sometimes|required|string|max:255',
        //     'email' => 'sometimes|required|email|unique:employees,email' . $id,
        //     'department' => 'sometimes|required|string|max:255',
        //     'phone' => 'nullable|string|max:20'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $employee->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
            'data' => $employee
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully'
        ], 200);
    }
}
