<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Branch;  

class BranchController extends Controller
{
    public function index()
    {
        return view('admin.branches.index');
    }
    public function create()
    {
        // Code to show form for creating a new branch
        return view('admin.branches.create');
    }
    public function store(Request $request)
    {
        $request->validate( [
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'branch_phone' => 'required|string|max:15',
            'branch_email' => 'required|email|max:255',
        ]);

        try{
            $branch = Branch::create($request->only([
                'branch_name',
                'branch_address',
                'branch_phone',
                'branch_email'
            ]));
        }
        catch(\Exception $e){
            Log::error('Error creating branch:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to create branch'], 500);
            return redirect()->route('admin.branches.index')->with('error', 'Failed to create branch.');
        }

        Log::info('Successful adding branch', $request->all());
        // return response()->json(['message' => 'Branch created successfully', 'branch' => $branch], 201);
        return redirect()->route('admin.branches.index')->with('success', 'Branch created successfully');       

    }
    public function show($id)
    {
        // Code to show a specific branch

        $branch = Branch::findOrFail($id);
        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }
        return response()->json($branch);
    }
    public function edit($id)
    {
        // Code to show form for editing a branch
        $branch = Branch::findOrFail($id);
        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }
        return view('admin.branches.edit', compact('branch'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'branch_phone' => 'required|string|max:15',
            'branch_email' => 'required|email|max:255',
        ]);

        $branch = Branch::findOrFail($id);
        if (!$branch) {
            // return response()->json(['error' => 'Branch not found'], 404);
            return redirect()->route('admin.branches.index')->with('error', 'Branch not found');
        }

        try {
            $branch->update($request->only([
                'branch_name',
                'branch_address',
                'branch_phone',
                'branch_email'
            ]));
        } catch (\Exception $e) {
            Log::error('Error updating branch:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to update branch'], 500);
            return redirect()->route('admin.branches.index')->with('error', 'Failed to update branch.');
        }

        Log::info('Successful updating branch', $request->all());
        // return response()->json(['message' => 'Branch updated successfully', 'branch' => $branch], 200);
        return redirect()->route('admin.branches.index')->with('success', 'Branch updated successfully.');
    }
    public function destroy($id)
    {
        // Code to delete a specific branch

        $branch = Branch::findOrFail($id);
        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }
        try {
            $branch->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting branch:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete branch'], 500);
        }
        Log::info('Branch deleted successfully', ['branch_id' => $id]);
    }

    public function getAllBranches()
    {
        // Code to get all branches
        $branches = Branch::all();
        if ($branches->isEmpty()) {
            return response()->json(['message' => 'No branches found'], 404);
        }
        return response()->json($branches, 200);
    }
}
