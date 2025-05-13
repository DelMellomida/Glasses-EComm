<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return view('admin.products');
        // return response()->json(['message' => 'Product index']);
        $products = Product::query();

        if ($request->has('category')) {
            $products->where('category', $request->category);
        }

        return view('welcome', [
            'products' => $products->get(),
        ]);
        // return response()->json($products);
    }

    public function listAllProducts()
    {
        $products = Product::all();

        // return view('admin.products', [
        //     'products' => $products,
        // ]);

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'product_image_id' => 'nullable|exists:product_images,id',
        ]);

        Log::info('Request data:', $request->all());

        try{
            $product = Product::create($request->only([
                'name',
                'description',
                'stock_quantity',
                'price',
                'product_image_id',
            ]));
        }
        catch(\Exception $e){
            Log::error('Error creating product:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create product'], 500);
        }

        Log::info('Successful adding product', $request->all());
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'product_image_id' => 'nullable|exists:product_images,id',
        ]);

        $product = Product::findOrFail($id);

        try{
            $product->update($request->only([
                'name',
                'description',
                'stock_quantity',
                'price',
                'product_image_id'
            ]));
        }
        catch(\Exception $e){
            Log::error('Error updating product:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update product'], 500);
        }

        Log::info('Product updated successfully', $request->all());
        return response()->json(['message' => 'Product updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting product:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete product'], 500);
        }
    }

}
