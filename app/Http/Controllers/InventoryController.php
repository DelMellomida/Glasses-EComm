<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Branch;

class InventoryController extends Controller
{
    public function index()
    {
        return view('admin.inventory.index');
    }

    public function create()
    {
        $products = Product::all();
        $branches = Branch::all();
        return view('admin.inventory.create', [
            'products' => $products,
            'branches' => $branches,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'stock_quantity' => 'required|integer',
            'branch_id' => 'required|integer',
        ]);

        try{
            $inventory = Inventory::create([
                'product_id' => $request->product_id,
                'stock_quantity' => $request->stock_quantity,
                'branch_id' => $request->branch_id,
            ]);

        } catch(\Exception $e){
            Log::error('Error creating inventory:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to create inventory'], 500);
            return redirect()->route('admin.inventory.index')->with('error', 'Failed to create inventory.');
        };

        Log::info('Successful adding inventory', $request->all());
        // return response()->json(['message' => 'Inventory created successfully', 'inventory' => $inventory], 201);
        return redirect()->route('admin.inventory.index')->with('success', 'Inventory created successfully.');
        
    }

    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        if (!$inventory) {
            return response()->json(['error' => 'Inventory not found'], 404);
        }
        return response()->json($inventory);
    }

    public function edit($id)
    {
        // Code to show form for editing an inventory
        $inventory = Inventory::findOrFail($id);
        $products = Product::all();
        $branches = Branch::all();
        if (!$inventory) {
            return response()->json(['error' => 'Inventory not found'], 404);
        }
        return view('admin.inventory.edit', [
            'inventory' => $inventory,
            'products' => $products,
            'branches' => $branches,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'stock_quantity' => 'required|integer',
            'branch_id' => 'required|integer',
        ]);

        try{
            $inventory = Inventory::findOrFail($id);
            if (!$inventory) {
                return response()->json(['error' => 'Inventory not found'], 404);
            }

            $inventory->update($request->only([
                'product_id',
                'stock_quantity',
                'branch_id',
            ]));

        } catch(\Exception $e){
            Log::error('Error updating inventory:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to update inventory'], 500);
            return redirect()->route('admin.inventory.index')->with('error', 'Failed to update inventory.');
        };

        Log::info('Successful updating inventory', $request->all());
        // return response()->json(['message' => 'Inventory updated successfully', 'inventory' => $inventory], 200);
        return redirect()->route('admin.inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        if (!$inventory) {
            return response()->json(['error' => 'Inventory not found'], 404);
        }

        try{
            $inventory->delete();
        } catch(\Exception $e){
            Log::error('Error deleting inventory:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to delete inventory'], 500);
            return redirect()->route('admin.inventory.index')->with('error', 'Failed to delete inventory.');
        };

        Log::info('Successful deleting inventory', ['id' => $id]);
        // return response()->json(['message' => 'Inventory deleted successfully'], 200);
        return redirect()->route('admin.inventory.index')->with('success', 'Inventory deleted successfully.');
    }
    public function listInventory()
    {
        $inventory = Inventory::all();
        return response()->json($inventory);
    }
}
