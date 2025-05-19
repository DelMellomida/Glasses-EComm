<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.list');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function listCategories(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select(['category_id', 'category_name', 'category_desc']);
            return DataTables::of($categories)
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.category.edit', ['id' => $row->category_id]);
                    $deleteUrl = route('admin.category.destroy', ['id' => $row->category_id]);
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
            return redirect()->route('category.index')->with('error', 'Failed to create category.');
        }

        Log::info('Successful adding category', $request->all());
        // return response()->json(['message' => 'Branch created successfully', 'branch' => $branch], 201);    
        return redirect()->route('category.index')->with('success', 'Branch created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return view('admin.category.edit', compact('category'));
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
            return redirect()->route('category.index')->with('error', 'Error updating category');
        }
        Log::info('Successful updating category', $request->all());
        // return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
        return redirect()->route('category.index')->with('success', 'Successful updating category.');
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
            return redirect()->route('category.index')->with('error', 'Error deleting category');
        }
        // return redirect()->route('categories.index');
        return redirect()->route('category.index')->with('success', 'Successfully delete category');
    }

    public function showAllCategoriesInView()
    {
        $categories = Category::all(); 
        return view('admin.categories', compact('categories'));
    }
}
