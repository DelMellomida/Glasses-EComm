<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        return view('inventory.index');
    }

    public function create()
    {

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
            return response()->json(['error' => 'Failed to create inventory'], 500);
        };

        Log::info('Successful adding inventory', $request->all());
        return response()->json(['message' => 'Inventory created successfully', 'inventory' => $inventory], 201);
        
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
            return response()->json(['error' => 'Failed to update inventory'], 500);
        };

        Log::info('Successful updating inventory', $request->all());
        return response()->json(['message' => 'Inventory updated successfully', 'inventory' => $inventory], 200);
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
            return response()->json(['error' => 'Failed to delete inventory'], 500);
        };

        Log::info('Successful deleting inventory', ['id' => $id]);
        return response()->json(['message' => 'Inventory deleted successfully'], 200);
    }
    public function listInventory()
    {
        $inventory = Inventory::all();
        return response()->json($inventory);
    }
}
