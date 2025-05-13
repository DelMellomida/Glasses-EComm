<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class OrderController extends Controller
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
            'order_total' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        try {
            $order = Order::create([
                'order_total' => $request->order_total,
                'purchase_date' => $request->purchase_date,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating order:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'order_total' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->update([
                'order_total' => $request->order_total,
                'purchase_date' => $request->purchase_date,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting order:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete order'], 500);
        }
        Log::info('Successful deleting order', ['order_id' => $id]);
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}
