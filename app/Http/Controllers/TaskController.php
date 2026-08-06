<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('employee')->get();
        return response()->json([
            'status' => 'success',
            'data' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TaskRequest $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $tasks = Task::create($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'data' => $tasks
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tasks = Task::with('employee')->find($id);
        if (!$tasks) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $tasks
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, $id)
    {
        $tasks = Task::find($id);
        if (!$tasks) {
            return response()->json([
                'status' => 'errors',
                'message' => 'Task not found',
            ], 404);
        }
        $tasks->update($request->validated());
        return response()->json([
            'status' => 'success',
            'message'=> 'Task Updated Successfully',
            'data' => $tasks
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tasks = Task::find($id);
        if (!$tasks) {
            return response()->json([
                'status' => 'errors',
                'message' => 'Task not found',
            ], 404);
        }
        $tasks->delete();
         return response()->json([
            'status' => 'success',
            'message'=> 'Task Deleted Successfully',
            'data' => $tasks
        ]);
    }
}
