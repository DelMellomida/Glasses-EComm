<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_desc'=> 'required|string|max:255',
        ]);

        try{
            $branch = Category::create($request->only([
                'category_name',
                'category_desc'
            ]));
        }
        catch(\Exception $e){
            Log::error('Error creating category:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to create category'], 500);
            return redirect()->route('admin.categories.index')->with('error', 'Failed to create category.');
        }

        Log::info('Successful adding category', $request->all());
        // return response()->json(['message' => 'Branch created successfully', 'branch' => $branch], 201);    
        return redirect()->route('admin.categories.index')->with('success', 'Branch created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update the category
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_desc'=> 'required|string|max:255',
        ]);
        try{
            $category = Category::findOrFail($id);
            $category->update($request->only([
                'category_name',
                'category_desc'
            ]));
        }
        catch(\Exception $e){
            Log::error('Error updating category:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to update category'], 500);
            return redirect()->route('admin.categories.index')->with('error', 'Error updating category');
        }
        Log::info('Successful updating category', $request->all());
        // return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
        return redirect()->route('admin.categories.index')->with('success', 'Successful updating category.');
    }

    public function destroy($id)
    {
        // Logic to delete the category
        try{
            $category = Category::findOrFail($id);
            $category->delete();
        }
        catch(\Exception $e){
            Log::error('Error deleting category:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to delete category'], 500);
            return redirect()->route('admin.categories.index')->with('error', 'Error deleting category');
        }
        // return redirect()->route('categories.index');
        return redirect()->route('admin.categories.index')->with('success', 'Successfully delete category');
    }

    public function showAllCategoriesInView()
    {
        $categories = Category::all(); 
        return view('admin.categories', compact('categories'));
    }
}
