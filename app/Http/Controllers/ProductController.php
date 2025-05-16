<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query();

        if ($request->has('category')) {
            $products->where('category', $request->category);
        }

        return view('welcome', [
            'products' => $products->get(),
        ]);
    }

    public function listAllProducts()
    {
        $products = Product::all();

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $productImages = ProductImage::all();

        return view('admin.products.create', [
            'categories' => $categories,
            'productImages' => $productImages,
        ]);
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

        try {
            $product = Product::create($request->only([
                'name',
                'description',
                'stock_quantity',
                'price',
                'product_image_id',
            ]));
        } catch (\Exception $e) {
            Log::error('Error creating product:', ['error' => $e->getMessage()]);
            return redirect()->route('products.create')->with('error', 'Failed to create product.');
        }

        Log::info('Successfully added product', $request->all());
        return redirect()->route('products.create')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $productImages = ProductImage::all();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'productImages' => $productImages,
        ]);
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

        try {
            $product->update($request->only([
                'name',
                'description',
                'stock_quantity',
                'price',
                'product_image_id'
            ]));
        } catch (\Exception $e) {
            Log::error('Error updating product:', ['error' => $e->getMessage()]);
            return redirect()->route('products.edit', $id)->with('error', 'Failed to update product.');
        }

        Log::info('Product updated successfully', $request->all());
        return redirect()->route('products.edit', $id)->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting product:', ['error' => $e->getMessage()]);
            return redirect()->route('products.index')->with('error', 'Failed to delete product.');
        }
    }

    public function showAllProductsInGuestView()
    {
        $products = Product::select('product_name', 'product_description', 'price', 'product_image_id')->get();
        $productImages = ProductImage::all();
        return view('guest.guest-home', compact('products', 'productImages'));
    }
}
