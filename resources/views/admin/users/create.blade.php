<x-admin-layout>
    <div class="flex justify-center items-start min-h-screen bg-gray-100 py-16">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-xl p-10 mt-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Add User</h2>
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center font-semibold">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        @error('name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        @error('email') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                        <input type="tel" name="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" value="{{ old('tel') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        @error('email') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Password</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        @error('password') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('user.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold shadow hover:bg-gray-300 transition">
                        &larr; Go Back
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-teal-600 text-white rounded-lg font-semibold shadow hover:bg-teal-700 transition"
                        style="background-color: #0891b2; color: #fff;">
                        Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>