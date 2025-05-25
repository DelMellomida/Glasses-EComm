<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

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
        return view('admin.products.list');
    }

    public function listProducts(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('images')->select(['product_id', 'product_name', 'product_description', 'price', 'stock', 'category_id']);

            return DataTables::of($products)
                ->addColumn('images', function($row) {
                    if ($row->images->count() > 0) {
                        $imgs = '';
                        foreach ($row->images as $img) {
                            $imgs .= '<img src="'.$img->image_path.'" class="inline-block w-10 h-10 object-cover rounded mr-1 product-image-thumb" data-src="'.$img->image_path.'" alt="Product Image" />';
                        }
                        return $imgs;
                    }
                    return '<span class="text-gray-400">No Images</span>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.product.edit', ['id' => $row->product_id]);
                    $deleteUrl = route('admin.product.destroy', ['id' => $row->product_id]);
                    return '
                        <a href="'.$editUrl.'" class="text-green-400 mr-2">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="text-red-400" onclick="return confirm(\'Delete this product?\')">Delete</button>
                        </form>
                    ';
                })
                ->editColumn('product_name', function($row) {
                    return e($row->product_name);
                })
                ->editColumn('product_description', function($row) {
                    return e($row->product_description);
                })
                ->editColumn('price', function($row) {
                    return '₱' . number_format($row->price, 2);
                })
                ->rawColumns(['images', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:category,category_id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // Check Cloudinary configuration
            if (empty(env('CLOUDINARY_CLOUD_NAME')) || empty(env('CLOUDINARY_API_KEY')) || empty(env('CLOUDINARY_API_SECRET'))) {
                Log::error('Cloudinary configuration missing');
                return redirect()->route('products.index')->with('error', 'Image upload service not configured properly.');
            }

            $product = Product::create([
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            // Debug: Log the created product
            Log::info('Product created', [
                'product_id' => $product->product_id,
                'primary_key' => $product->getKey(),
                'product_data' => $product->toArray()
            ]);

            // Handle multiple image uploads using direct Cloudinary API
            if ($request->hasFile('images')) {
                $cloudinary = new \Cloudinary\Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key' => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET')
                    ],
                    'url' => [
                        'secure' => true,
                    ],
                    'api' => [
                        'timeout' => 60,
                        'chunk_size' => 20000000,
                        'upload_timeout' => 60,
                    ]
                ]);

                $uploadedImages = [];
                $failedUploads = [];

                foreach ($request->file('images') as $index => $image) {
                    try {
                        if (!$image->isValid()) {
                            $failedUploads[] = "Image " . ($index + 1) . ": Invalid file";
                            continue;
                        }

                        $tempPath = $image->getRealPath();
                        
                        // Use the product's primary key for the folder
                        $uploadResult = $cloudinary->uploadApi()->upload($tempPath, [
                            'folder' => 'products/' . $product->getKey(),
                            'resource_type' => 'image',
                            'transformation' => [
                                'quality' => 'auto',
                                'fetch_format' => 'auto'
                            ]
                        ]);

                        if (!isset($uploadResult['secure_url'])) {
                            $failedUploads[] = "Image " . ($index + 1) . ": Upload failed - no URL returned";
                            continue;
                        }

                        // Debug: Log before creating ProductImage
                        Log::info('About to create ProductImage', [
                            'product_id' => $product->getKey(),
                            'image_path' => $uploadResult['secure_url']
                        ]);

                        // Create database record for the image using the primary key
                        $productImage = ProductImage::create([
                            'product_id' => $product->getKey(), // Use getKey() to get the primary key value
                            'image_path' => $uploadResult['secure_url'],
                            'cloudinary_public_id' => $uploadResult['public_id'] ?? null,
                        ]);

                        // Debug: Log after creating ProductImage
                        Log::info('ProductImage created', [
                            'image_id' => $productImage->id,
                            'product_id' => $productImage->product_id,
                            'image_data' => $productImage->toArray()
                        ]);

                        $uploadedImages[] = [
                            'id' => $productImage->id,
                            'url' => $uploadResult['secure_url'],
                            'public_id' => $uploadResult['public_id'] ?? null
                        ];

                    } catch (\Cloudinary\Api\Exception\ApiError $e) {
                        $failedUploads[] = "Image " . ($index + 1) . ": Cloudinary API Error - " . $e->getMessage();
                        Log::error('Cloudinary API Error', [
                            'product_id' => $product->getKey(),
                            'error' => $e->getMessage()
                        ]);
                    } catch (\Exception $e) {
                        $failedUploads[] = "Image " . ($index + 1) . ": " . $e->getMessage();
                        Log::error('General error during image upload', [
                            'product_id' => $product->getKey(),
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }

                if (empty($uploadedImages) && $request->hasFile('images') && count($request->file('images')) > 0) {
                    DB::rollBack();
                    return redirect()->route('products.index')->with('error', 'Product creation failed: No images could be uploaded.');
                }
            }

            DB::commit();

            $message = 'Product created successfully.';
            if (!empty($uploadedImages)) {
                $message .= ' ' . count($uploadedImages) . ' image(s) uploaded.';
            }
            if (!empty($failedUploads)) {
                $message .= ' Some images failed to upload: ' . implode(', ', $failedUploads);
            }

            return redirect()->route('products.index')->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error creating product', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['images'])
            ]);
            
            return redirect()->route('products.index')->with('error', 'Failed to create product: ' . $e->getMessage());
        }
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
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:category,category_id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $product = Product::findOrFail($id);

        DB::beginTransaction();

        try {
            $product->update([
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            // Handle new image uploads using the same direct API approach
            if ($request->hasFile('images')) {
                // Check Cloudinary configuration
                if (empty(env('CLOUDINARY_CLOUD_NAME')) || empty(env('CLOUDINARY_API_KEY')) || empty(env('CLOUDINARY_API_SECRET'))) {
                    Log::error('Cloudinary configuration missing');
                    return redirect()->route('products.index')->with('error', 'Image upload service not configured properly.');
                }

                $cloudinary = new \Cloudinary\Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key' => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET')
                    ],
                    'url' => [
                        'secure' => true,
                    ],
                    'api' => [
                        'timeout' => 60,
                        'chunk_size' => 20000000,
                        'upload_timeout' => 60,
                    ]
                ]);

                foreach ($request->file('images') as $image) {
                    try {
                        if (!$image->isValid()) {
                            continue;
                        }

                        $tempPath = $image->getRealPath();
                        
                        $uploadResult = $cloudinary->uploadApi()->upload($tempPath, [
                            'folder' => 'products/' . $product->getKey(),
                            'resource_type' => 'image',
                            'transformation' => [
                                'quality' => 'auto',
                                'fetch_format' => 'auto'
                            ]
                        ]);

                        if (isset($uploadResult['secure_url'])) {
                            ProductImage::create([
                                'product_id' => $product->getKey(),
                                'image_path' => $uploadResult['secure_url'],
                                'cloudinary_public_id' => $uploadResult['public_id'] ?? null,
                            ]);
                        }

                    } catch (\Exception $e) {
                        Log::error('Error uploading image during update', [
                            'product_id' => $product->getKey(),
                            'error' => $e->getMessage()
                        ]);
                        // Continue with other images
                        continue;
                    }
                }
            }

            DB::commit();

            Log::info('Product updated successfully', ['product_id' => $product->getKey()]);
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error updating product:', [
                'product_id' => $id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('products.index')->with('error', 'Failed to update product.');
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $product = Product::with('images')->findOrFail($id);

            $cloudinary = null;
            $cloudinaryConfigured = false;

            if (!empty(env('CLOUDINARY_CLOUD_NAME')) && !empty(env('CLOUDINARY_API_KEY')) && !empty(env('CLOUDINARY_API_SECRET'))) {
                try {
                    $cloudinary = new \Cloudinary\Cloudinary([
                        'cloud' => [
                            'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                            'api_key' => env('CLOUDINARY_API_KEY'),
                            'api_secret' => env('CLOUDINARY_API_SECRET')
                        ],
                        'url' => [
                            'secure' => true,
                        ],
                        'api' => [
                            'timeout' => 60,
                        ]
                    ]);
                    $cloudinaryConfigured = true;
                } catch (\Exception $e) {
                    Log::error('Failed to initialize Cloudinary for deletion', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $deletedFromCloudinary = 0;
            $failedCloudinaryDeletes = 0;

            foreach ($product->images as $image) {
                if ($cloudinaryConfigured && !empty($image->cloudinary_public_id)) {
                    try {
                        $response = $cloudinary->uploadApi()->destroy($image->cloudinary_public_id);
                        
                        Log::info('Cloudinary delete response', [
                            'image_id' => $image->id,
                            'public_id' => $image->cloudinary_public_id,
                            'response' => $response
                        ]);

                        if (is_array($response) && isset($response['result'])) {
                            if ($response['result'] === 'ok' || $response['result'] === 'not found') {
                                $deletedFromCloudinary++;
                                Log::info('Image deleted from Cloudinary', [
                                    'image_id' => $image->id,
                                    'public_id' => $image->cloudinary_public_id,
                                    'result' => $response['result']
                                ]);
                            } else {
                                $failedCloudinaryDeletes++;
                                Log::warning('Cloudinary delete returned unexpected result', [
                                    'image_id' => $image->id,
                                    'public_id' => $image->cloudinary_public_id,
                                    'response' => $response
                                ]);
                            }
                        } else {
                            $failedCloudinaryDeletes++;
                            Log::error('Cloudinary delete returned invalid response', [
                                'image_id' => $image->id,
                                'public_id' => $image->cloudinary_public_id,
                                'response' => $response,
                                'response_type' => gettype($response)
                            ]);
                        }

                    } catch (\Cloudinary\Api\Exception\ApiError $e) {
                        $failedCloudinaryDeletes++;
                        Log::error('Cloudinary API error during image deletion', [
                            'image_id' => $image->id,
                            'public_id' => $image->cloudinary_public_id,
                            'error' => $e->getMessage(),
                            'code' => $e->getCode()
                        ]);
                    } catch (\Exception $e) {
                        $failedCloudinaryDeletes++;
                        Log::error('General error during Cloudinary image deletion', [
                            'image_id' => $image->id,
                            'public_id' => $image->cloudinary_public_id,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                } else {
                    if (!$cloudinaryConfigured) {
                        Log::warning('Cloudinary not configured, skipping cloud deletion', [
                            'image_id' => $image->id
                        ]);
                    } else {
                        Log::warning('No Cloudinary public_id found for image', [
                            'image_id' => $image->id,
                            'public_id' => $image->cloudinary_public_id
                        ]);
                    }
                }

                $image->delete();
            }

            $product->delete();

            DB::commit();

            $message = 'Product deleted successfully.';
            if ($product->images->count() > 0) {
                $message .= ' ' . $product->images->count() . ' image(s) removed from database.';
                if ($deletedFromCloudinary > 0) {
                    $message .= ' ' . $deletedFromCloudinary . ' image(s) deleted from Cloudinary.';
                }
                if ($failedCloudinaryDeletes > 0) {
                    $message .= ' ' . $failedCloudinaryDeletes . ' image(s) failed to delete from Cloudinary (check logs).';
                }
            }

            Log::info('Product deleted successfully', [
                'product_id' => $id,
                'images_deleted_from_db' => $product->images->count(),
                'images_deleted_from_cloudinary' => $deletedFromCloudinary,
                'failed_cloudinary_deletes' => $failedCloudinaryDeletes
            ]);

            return redirect()->route('products.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error deleting product', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function showAllProductsInGuestView()
    {
<<<<<<< Updated upstream
        $products = Product::select('product_name', 'product_description', 'price', 'product_image_id', 'category_id')->get();
=======
        $products = Product::select('product_name', 'product_description', 'price')->get();
>>>>>>> Stashed changes
        $productImages = ProductImage::all();
        
        return view('guest.guest-home', compact('products', 'productImages'));

    }
      public function showAllProductsInProductsView()
    {
<<<<<<< Updated upstream
        $products = Product::select('product_name', 'product_description', 'price', 'product_image_id', 'category_id')->get();
=======
        $products = Product::select('product_name', 'product_description', 'price')->get();
>>>>>>> Stashed changes
        $productImages = ProductImage::all();
        
        return view('product.home', compact('products', 'productImages'));

    }
}
