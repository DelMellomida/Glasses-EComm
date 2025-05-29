<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\EventLogger;

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
            $categories = Category::select(['category_id', 'category_name', 'category_desc', 'availability_type'])
                ->orderBy('created_at', 'desc');
            return DataTables::of($categories)
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.category.edit', ['id' => $row->category_id]);
                    $deleteUrl = route('admin.category.destroy', ['id' => $row->category_id]);
                    return '
                        <a href="'.$editUrl.'" class="inline-flex items-center px-2 py-1 text-[#118ab2] hover:text-[#ef476f]" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h2v2h-2z"/>
                            </svg>
                        </a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="inline-flex items-center px-2 py-1 text-[#ef476f] hover:text-[#ffd166]" title="Delete" onclick="return confirm(\'Delete this category?\')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
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
            'availability_type' => 'required|in:online,on-branch',
        ]);

        try{
            $branch = Category::create($request->only([
                'category_name',
                'category_desc',
                'availability_type'
            ]));

            EventLogger::log('Category Creation', 'Category created successfully', [
                'category_id' => $branch->category_id,
                'category_name' => $branch->category_name,
                'category_desc' => $branch->category_desc,
                'availability_type' => $branch->availability_type,
            ]);
        }
        catch(\Exception $e){
            Log::error('Error creating category:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to create category'], 500);
            EventLogger::log('Category Creation Failed', 'Failed to create category', [
                'error_message' => $e->getMessage(),
                'input_data' => $request->except('_token'),
            ]);
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
            'availability_type' => 'required|in:online,on-branch',
        ]);
        try{
            $category = Category::findOrFail($id);
            $category->update($request->only([
                'category_name',
                'category_desc',
                'availability_type'
            ]));
            EventLogger::log('Category Update', 'Category updated successfully', [
                'category_id' => $category->category_id,
                'category_name' => $category->category_name,
                'category_desc' => $category->category_desc,
                'availability_type' => $category->availability_type,
            ]);
        }
        catch(\Exception $e){
            Log::error('Error updating category:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to update category'], 500);
            EventLogger::log('Category Update Failed', 'Failed to update category', [
                'error_message' => $e->getMessage(),
                'input_data' => $request->except('_token'),
            ]);
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
            EventLogger::log('Category Deletion', 'Category deleted successfully', [
                'category_id' => $category->category_id,
                'category_name' => $category->category_name,
                'category_desc' => $category->category_desc,
                'availability_type' => $category->availability_type,
            ]);
            $category->delete();
        }
        catch(\Exception $e){
            Log::error('Error deleting category:', ['error' => $e->getMessage()]);
            // return response()->json(['error' => 'Failed to delete category'], 500);
            EventLogger::log('Category Deletion Failed', 'Failed to delete category', [
                'error_message' => $e->getMessage(),
            ]);
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
