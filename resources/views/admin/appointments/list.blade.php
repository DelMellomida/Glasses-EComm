{{-- filepath: resources/views/admin/appointments/list.blade.php --}}
<x-admin-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 mt-20" x-data="{ showEdit: false, showDelete: false, selected: null }">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Appointments</h1>
        <div class="space-y-6">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:gap-4">
                <form method="GET" action="{{ route('admin.appointments') }}" class="flex items-center gap-2">
                    <label for="branch_id" class="font-semibold text-gray-700">Filter by Branch:</label>
                    <select name="branch_id" id="branch_id" class="border rounded px-3 py-2" onchange="this.form.submit()">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @if(request('branch_id') == $branch->id) selected @endif>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            @forelse($appointments as $appointment)
                <div class="bg-white shadow rounded-2xl p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-semibold text-blue-700 text-lg">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                            <span class="text-gray-500 text-sm">{{ $appointment->appointment_time }}</span>
                        </div>
                        <div class="text-gray-700">
                            <span class="font-semibold">Branch:</span> {{ $appointment->branch->branch_name ?? '-' }}<br>
                            <span class="font-semibold">Type:</span> {{ $appointment->type }}<br>
                            <span class="font-semibold">Product:</span> {{ $appointment->product->product_name ?? '-' }}<br>
                            <span class="font-semibold">User:</span> {{ $appointment->user->name ?? '-' }}
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-4 md:mt-0">
                        <!-- Edit Button -->
                        <button
                            @click="showEdit = true; selected = {{ $appointment->toJson() }}"
                            class="inline-flex items-center justify-center p-2 text-blue-600 hover:text-blue-800"
                            title="Edit"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3z"/>
                            </svg>
                        </button>
                        <!-- Delete Button -->
                        <button
                            @click="showDelete = true; selected = {{ $appointment->toJson() }}"
                            class="inline-flex items-center justify-center p-2 text-red-600 hover:text-red-800"
                            title="Delete"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-16">No appointments found.</div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $appointments->links() }}
        </div>

        <!-- Edit Modal -->
        <div x-show="showEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50" style="display: none;">
            <div class="bg-white rounded-2xl shadow-xl ring-1 ring-gray-200 p-8 w-full max-w-md relative">
                <button @click="showEdit = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none" title="Close">&times;</button>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Edit Appointment</h3>
                <form x-ref="editForm" method="POST" @submit.prevent="
                    fetch('/admin/appointments/' + selected.id, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            appointment_date: selected.appointment_date,
                            appointment_time: selected.appointment_time,
                            type: selected.type,
                            branch_id: selected.branch_id
                        })
                    }).then(() => { showEdit = false; window.location.reload(); });
                ">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Date</label>
                        <input type="date" class="border rounded px-3 py-2 w-full"
                            x-model="selected.appointment_date" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Time</label>
                        <input type="text" class="border rounded px-3 py-2 w-full"
                            x-model="selected.appointment_time" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Branch</label>
                        <select class="border rounded px-3 py-2 w-full"
                            x-model="selected.branch_id" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Type</label>
                        <input type="text" class="border rounded px-3 py-2 w-full"
                            x-model="selected.type" required>
                    </div>
                    <!-- Add more fields as needed -->
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" @click="showEdit = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="showDelete" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50" style="display: none;">
            <div class="bg-white rounded-2xl shadow-xl ring-1 ring-gray-200 p-8 w-full max-w-md relative">
                <button @click="showDelete = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none" title="Close">&times;</button>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Delete Appointment</h3>
                <p class="mb-6">Are you sure you want to delete this appointment?</p>
                <form x-ref="deleteForm" method="POST" @submit.prevent="
                    fetch('/admin/appointments/' + selected.id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(() => { showDelete = false; window.location.reload(); });
                ">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>