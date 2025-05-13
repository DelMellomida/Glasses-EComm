<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\OrderDetail;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'payment_type' => 'required|string',
        ]);

        try {
            // Assuming you have an OrderDetail model
            $orderDetail = OrderDetail::create([
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating order details:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create order detail'], 500);
        }

        return response()->json(['message' => 'Order detail created successfully', 'order_detail' => $orderDetail], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        if (!$orderDetail) {
            return response()->json(['error' => 'Order detail not found'], 404);
        }
        return response()->json($orderDetail);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'payment_type' => 'required|string',
        ]);

        try {
            $orderDetail = OrderDetail::findOrFail($id);
            if (!$orderDetail) {
                return response()->json(['error' => 'Order detail not found'], 404);
            }

            $orderDetail->update($request->all());
        } catch (\Exception $e) {
            Log::error('Error updating order detail:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update order detail'], 500);
        }

        return response()->json(['message' => 'Order detail updated successfully', 'order_detail' => $orderDetail], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $orderDetail = OrderDetail::findOrFail($id);
            if (!$orderDetail) {
                return response()->json(['error' => 'Order detail not found'], 404);
            }

            $orderDetail->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting order detail:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete order detail'], 500);
        }

        return response()->json(['message' => 'Order detail deleted successfully'], 200);
    }
}
