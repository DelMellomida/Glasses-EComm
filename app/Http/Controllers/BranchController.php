<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Branch;  

class BranchController extends Controller
{
    public function index()
    {
        return view('branches.index');
    }
    public function create()
    {
        // Code to show form for creating a new branch
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
            return response()->json(['error' => 'Failed to create branch'], 500);
        }

        Log::info('Successful adding branch', $request->all());
        return response()->json(['message' => 'Branch created successfully', 'branch' => $branch], 201);        

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
            return response()->json(['error' => 'Branch not found'], 404);
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
            return response()->json(['error' => 'Failed to update branch'], 500);
        }

        Log::info('Successful updating branch', $request->all());
        return response()->json(['message' => 'Branch updated successfully', 'branch' => $branch], 200);
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
