<x-admin-layout>
    <div class="flex justify-center items-start min-h-screen bg-gray-100 py-16">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-xl p-10 mt-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Edit Product</h2>
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center font-semibold">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.product.update', $product->product_id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
                        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        @error('product_name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Product Description</label>
                        <textarea name="product_description" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('product_description', $product->product_description) }}</textarea>
                        @error('product_description') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Price</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" min="0" required>
                        @error('price') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" min="0" required>
                        @error('stock') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Category</label>
                        <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ (old('category_id', $product->category_id) == $category->category_id) ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Gender</label>
                        <select name="gender" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            <option value="unisex" {{ old('gender') == 'unisex' ? 'selected' : '' }} selected >Unisex</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }} >Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} selected >Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }} >Inactive</option>
                        </select>
                        @error('status') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Product Images</label>
                        <input type="file" name="images[]" multiple class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        @error('images') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        @error('images.*') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($product->images as $img)
                                <div class="relative group">
                                    <img src="{{ $img->image_path }}" class="w-32 h-32 object-cover rounded border border-gray-300" alt="Product Image">
                                    <!-- Optionally add a delete button for each image here -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('products.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold shadow hover:bg-gray-300 transition">
                        &larr; Go Back
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-teal-600 text-white rounded-lg font-semibold shadow hover:bg-teal-700 transition"
                        style="background-color: #0891b2; color: #fff;">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>