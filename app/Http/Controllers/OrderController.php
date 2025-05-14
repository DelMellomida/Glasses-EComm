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
        return view('admin.orders.index', [
            'orders' => Order::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create');
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
            return redirect()->route('orders.index')->with('error', 'Failed to create order.');
        }

        Log::info('Successfully created order', ['order_id' => $order->id]);
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }
        return view('admin.orders.edit', compact('order'));
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
            return redirect()->route('orders.index')->with('error', 'Failed to update order.');
        }

        Log::info('Successfully updated order', ['order_id' => $order->id]);
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
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
            return redirect()->route('orders.index')->with('error', 'Failed to delete order.');
        }
        Log::info('Successfully deleted order', ['order_id' => $id]);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
