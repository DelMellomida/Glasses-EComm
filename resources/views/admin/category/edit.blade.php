<x-admin-layout>
    <div class="flex justify-center items-start min-h-screen bg-gray-100 py-16">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-xl p-10 mt-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Edit Category</h2>
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center font-semibold">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.category.update', $category->category_id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Category Name</label>
                        <input type="text" name="category_name" value="{{ old('category_name', $category->category_name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        @error('category_name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Category Description</label>
                        <textarea name="category_desc" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('category_desc', $category->category_desc) }}</textarea>
                        @error('category_desc') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('category.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold shadow hover:bg-gray-300 transition">
                        &larr; Go Back
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-teal-600 text-white rounded-lg font-semibold shadow hover:bg-teal-700 transition"
                        style="background-color: #0891b2; color: #fff;">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>