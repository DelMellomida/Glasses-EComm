<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // You can implement this method as needed.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $users = User::all();
        $orders = Order::all();
        return view('admin.order_details.create', [
            'products' => $products,
            'users' => $users,
            'orders' => $orders,
        ]);
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
            $orderDetail = OrderDetail::create([
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating order detail:', ['error' => $e->getMessage()]);
            return redirect()->route('order_details.create')->with('error', 'Failed to create order detail.');
        }

        Log::info('Successfully created order detail', ['order_detail_id' => $orderDetail->id]);
        return redirect()->route('order_details.create')->with('success', 'Order detail created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        if (!$orderDetail) {
            return redirect()->route('order_details.index')->with('error', 'Order detail not found.');
        }
        return view('admin.order_details.show', compact('orderDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        $products = Product::all();
        $users = User::all();
        $orders = Order::all();
        return view('admin.order_details.edit', [
            'products' => $products,
            'users' => $users,
            'orders' => $orders,
            'orderDetail' => $orderDetail,
        ]);
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
                return redirect()->route('order_details.index')->with('error', 'Order detail not found.');
            }

            $orderDetail->update($request->all());
        } catch (\Exception $e) {
            Log::error('Error updating order detail:', ['error' => $e->getMessage()]);
            return redirect()->route('order_details.edit', $id)->with('error', 'Failed to update order detail.');
        }

        Log::info('Successfully updated order detail', ['order_detail_id' => $orderDetail->id]);
        return redirect()->route('order_details.edit', $id)->with('success', 'Order detail updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $orderDetail = OrderDetail::findOrFail($id);
            if (!$orderDetail) {
                return redirect()->route('order_details.index')->with('error', 'Order detail not found.');
            }

            $orderDetail->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting order detail:', ['error' => $e->getMessage()]);
            return redirect()->route('order_details.index')->with('error', 'Failed to delete order detail.');
        }

        Log::info('Successfully deleted order detail', ['order_detail_id' => $id]);
        return redirect()->route('order_details.index')->with('success', 'Order detail deleted successfully.');
    }
}
