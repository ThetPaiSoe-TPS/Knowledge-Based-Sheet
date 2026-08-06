<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemsRequest;
use App\Models\OrderItem;
use App\Models\OrderItems;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = OrderItems::with('order')->get();
        return response()->json([
            'status' => 'success',
            'data' => $items
        ], 200);
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
    public function store(OrderItemsRequest $request)
    {
        $items = OrderItems::create($request->validated());

        if (!$items) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fail to create Order Items',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $items = OrderItems::with('order')->find($id);

        if (!$items) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fail to create Order Items',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItems $orderItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderItemsRequest $request, $id)
    {
        $items= OrderItems::find($id);

        if (!$items) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fail to create Order Items',
            ], 404);
        }

        $items->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message'=> 'Successfully updated Order Items',
            'data' => $items->load('order')
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $items= OrderItems::find($id);

         if (!$items) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fail to create Order Items',
            ], 404);
        }

        $items->delete();

        return response()->json([
            'status' => 'success',
            'message'=> 'Successfully deleted Order Items',
            'data' => $items
        ], 200);

    }
}
