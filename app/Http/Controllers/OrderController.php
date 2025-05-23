<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    
    public function index()
    {
        return view('admin.orders.list', [
            'orders' => Order::all(),
        ]);
    }

    public function successfulIndex()
    {
        return view('admin.orders.successful-list');
    }

    public function failedIndex()
    {
        return view('admin.orders.failed-list');
    }

    public function listAllTransactions(Request $request){
        if ($request->ajax()) {
            $order = Order::select(['order_id', 'order_total', 'purchase_date', 'status']);
            return DataTables::of($order)
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.transaction.edit', ['id' => $row->order_id]);
                    $deleteUrl = route('admin.transaction.destroy', ['id' => $row->order_id]);
                    return '
                        <a href="'.$editUrl.'" class="text-green-400 mr-2">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="text-red-400" onclick="return confirm(\'Delete this category?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function listSuccessfulTransactions(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::where('status', 'successful')->select(['order_id', 'order_total', 'purchase_date', 'status']);
            return DataTables::of($order)
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.transaction.edit', ['id' => $row->order_id]);
                    $deleteUrl = route('admin.transaction.destroy', ['id' => $row->order_id]);
                    return '
                        <a href="'.$editUrl.'" class="text-green-400 mr-2">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="text-red-400" onclick="return confirm(\'Delete this category?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.orders.list', [
            'orders' => Order::where('status', 'successful')->get(),
        ]);
    }

    public function listFailedTransactions(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::where('status', 'failed')->select(['order_id', 'order_total', 'purchase_date', 'status']);
            return DataTables::of($order)
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.transaction.edit', ['id' => $row->order_id]);
                    $deleteUrl = route('admin.transaction.destroy', ['id' => $row->order_id]);
                    return '
                        <a href="'.$editUrl.'" class="text-green-400 mr-2">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="text-red-400" onclick="return confirm(\'Delete this category?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.orders.list', [
            'orders' => Order::where('status', 'failed')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_total' => 'required|numeric',
            'purchase_date' => 'required|date',
            'status' => 'required|string',
            'products' => 'required|array',
        ]);

        try {
            // Create the order (without user_id)
            $order = Order::create([
                'order_total' => $validated['order_total'],
                'purchase_date' => $validated['purchase_date'],
                'status' => $validated['status'],
            ]);

            // Save order details (with user_id)
            foreach ($request->products as $product_id => $productData) {
                if (isset($productData['selected']) && $productData['selected']) {
                    \App\Models\OrderDetail::create([
                        'order_id' => $order->order_id,
                        'product_id' => $product_id,
                        'quantity' => $productData['quantity'] ?? 1,
                        'user_id' => $validated['user_id'],
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error creating order:', ['error' => $e->getMessage()]);
            session()->flash('js_error', $e->getMessage());
            return redirect()->back()->withInput();
        }

        Log::info('Successfully created order', ['order_id' => $order->order_id]);
        return redirect()->route('all-transaction.index')->with('success', 'Order created!');
    }

    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return redirect()->route('all-transaction.index')->with('error', 'Order not found.');
        }
        return view('admin.orders.show', compact('order'));
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return redirect()->route('all-transaction.index')->with('error', 'Order not found.');
        }
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_total' => 'required|numeric',
            'purchase_date' => 'required|date',
            'status' => 'required|string',
            'products' => 'required|array',
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->update([
                'order_total' => $request->order_total,
                'purchase_date' => $request->purchase_date,
                'status' => $request->status,
            ]);

            // Remove old details
            $order->details()->delete();

            // Save new order details (with user_id)
            foreach ($request->products as $product_id => $productData) {
                if (isset($productData['selected']) && $productData['selected']) {
                    \App\Models\OrderDetail::create([
                        'order_id' => $order->order_id,
                        'product_id' => $product_id,
                        'quantity' => $productData['quantity'] ?? 1,
                        'user_id' => $request->user_id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error updating order:', ['error' => $e->getMessage()]);
            session()->flash('js_error', $e->getMessage());
            return redirect()->back()->withInput();
        }

        Log::info('Successfully updated order', ['order_id' => $order->order_id]);
        return redirect()->route('all-transaction.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting order:', ['error' => $e->getMessage()]);
            return redirect()->route('all-transaction.index')->with('error', 'Failed to delete order.');
        }
        Log::info('Successfully deleted order', ['order_id' => $id]);
        return redirect()->route('all-transaction.index')->with('success', 'Order deleted successfully.');
    }
}
