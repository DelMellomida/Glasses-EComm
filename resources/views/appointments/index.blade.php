<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-8 px-0 mt-16">
        <div class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left: Calendar and Booking -->
            <div class="md:col-span-2 flex flex-col">
                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-gray-200 p-6 flex-1 min-h-[600px]">
                    <h2 class="text-2xl font-bold mb-4">My Appointments</h2>
                    <div id="calendar" class="h-full"></div>
                </div>
            </div>

            <!-- Right: List of Bookings -->
            <div id="sidebar-bookings" class="bg-white rounded-2xl shadow-lg ring-1 ring-gray-200 p-6 h-full min-h-[600px] overflow-y-auto">
                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-gray-200 p-6 h-full min-h-[600px] overflow-y-auto">
                    <h3 class="text-xl font-bold mb-4">Upcoming Bookings</h3>
                    @forelse($appointments as $appt)
                        <div class="mb-4 border-b pb-3 last:border-b-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-blue-700">{{ $appt->type }}</span>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="text-sm text-gray-700 mt-1">
                                <span class="block"><span class="font-medium">Time:</span> {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</span>
                                <span class="block"><span class="font-medium">Branch:</span> {{ $appt->branch->branch_name ?? '' }}</span>
                                <span class="block"><span class="font-medium">Address:</span> {{ $appt->branch->branch_address ?? '' }}</span>
                                <span class="block"><span class="font-medium">Contact:</span> {{ $appt->branch->branch_phone ?? '' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500">No bookings yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Book Appointment Modal (unchanged) -->
    <div id="appointment-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl ring-1 ring-gray-200 p-8 w-full max-w-md">
            <div class="flex items-center mb-6">
                <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <h3 class="text-xl font-bold text-gray-800">Book Appointment</h3>
            </div>
            <form id="appointment-form" method="POST" action="{{ route('appointments.store') }}">
                @csrf
                <input type="hidden" name="appointment_date" id="appointment_date">
                <div class="mb-4">
                    <label for="branch_id" class="block font-semibold mb-1 text-gray-700">Branch</label>
                    <select name="branch_id" id="branch_id" class="border rounded px-3 py-2 w-full text-gray-900" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="appointment_time" class="block font-semibold mb-1 text-gray-700">Time</label>
                    <select name="appointment_time" id="appointment_time" class="border rounded px-3 py-2 w-full" required>
                        <option value="">Select Time</option>
                        <!-- Options will be filled by JS -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="type" class="block font-semibold mb-1 text-gray-700">Type</label>
                    <input type="text" name="type" id="type" class="border rounded px-3 py-2 w-full" required>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" id="close-modal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" style="background-color:#2563eb!important;color:white!important;padding:0.5rem 1rem!important;border-radius:0.375rem!important;" class="hover:bg-blue-700">Book</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Appointment Modal (all buttons in one row, delete via JS/hidden form) -->
    <div id="edit-appointment-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl ring-1 ring-gray-200 p-8 w-full max-w-md">
            <div class="flex items-center mb-6">
                <svg class="h-6 w-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7l-1.5-1.5"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-800">Edit Appointment</h3>
            </div>
            <form id="edit-appointment-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="appointment_id" id="edit_appointment_id">
                <div class="mb-4">
                    <label for="edit_branch_id" class="block font-semibold mb-1 text-gray-700">Branch</label>
                    <select name="branch_id" id="edit_branch_id" class="border rounded px-3 py-2 w-full text-gray-900" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit_appointment_date" class="block font-semibold mb-1 text-gray-700">Date</label>
                    <input type="date" name="appointment_date" id="edit_appointment_date" class="border rounded px-3 py-2 w-full" required readonly>
                </div>
                <div class="mb-4">
                    <label for="edit_appointment_time" class="block font-semibold mb-1 text-gray-700">Time</label>
                    <select name="appointment_time" id="edit_appointment_time" class="border rounded px-3 py-2 w-full" required>
                        <option value="">Select Time</option>
                        <!-- Options will be filled by JS -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit_type" class="block font-semibold mb-1 text-gray-700">Type</label>
                    <input type="text" name="type" id="edit_type" class="border rounded px-3 py-2 w-full" required>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="button" id="delete-appointment-btn" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                    <div class="flex gap-2">
                        <button type="button" id="close-edit-modal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" style="background-color:#2563eb!important;color:white!important;padding:0.5rem 1rem!important;border-radius:0.375rem!important;" class="hover:bg-blue-700">Update</button>
                    </div>
                </div>
            </form>
            <form id="delete-appointment-form" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        async function fetchAvailableTimes(date, branchId, excludeAppointmentId = null) {
            if (!date || !branchId) return [];
            let url = `/appointments/available-times?date=${date}&branch_id=${branchId}`;
            if (excludeAppointmentId) url += `&exclude=${excludeAppointmentId}`;
            const res = await fetch(url);
            if (!res.ok) return [];
            return await res.json();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('appointment-modal');
            const closeModal = document.getElementById('close-modal');
            const dateInput = document.getElementById('appointment_date');
            const branchSelect = document.getElementById('branch_id');
            const timeSelect = document.getElementById('appointment_time');

            const editModal = document.getElementById('edit-appointment-modal');
            const closeEditModal = document.getElementById('close-edit-modal');
            const editAppointmentId = document.getElementById('edit_appointment_id');
            const editAppointmentTime = document.getElementById('edit_appointment_time');
            const editType = document.getElementById('edit_type');
            const editBranchSelect = document.getElementById('edit_branch_id');
            const editAppointmentDate = document.getElementById('edit_appointment_date');
            const editAppointmentForm = document.getElementById('edit-appointment-form');
            const deleteAppointmentForm = document.getElementById('delete-appointment-form');
            const deleteAppointmentBtn = document.getElementById('delete-appointment-btn');

            let selectedEventId = null;
            let selectedEditDate = null;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                selectable: true,
                events: "{{ route('appointments.json') }}",
                eventDisplay: 'block',
                eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                eventContent: function(arg) {
                    return { html: `<span class="font-bold">${arg.event.title}</span>` };
                },
                select: function(info) {
                    modal.classList.remove('hidden');
                    dateInput.value = info.startStr;
                    branchSelect.value = '';
                    timeSelect.innerHTML = '<option value="">Select Time</option>';
                },
                eventClick: function(info) {
                    selectedEventId = info.event.id;
                    editAppointmentId.value = info.event.id;
                    editType.value = info.event.extendedProps.type || info.event.title;
                    selectedEditDate = info.event.startStr.substring(0,10);
                    editAppointmentDate.value = info.event.startStr.substring(0,10);

                    if (info.event.extendedProps.branch_id) {
                        editBranchSelect.value = info.event.extendedProps.branch_id;
                    }

                    fetchAvailableTimes(selectedEditDate, editBranchSelect.value, selectedEventId).then(times => {
                        editAppointmentTime.innerHTML = '<option value="">Select Time</option>';
                        times.forEach(time => {
                            const option = document.createElement('option');
                            option.value = time;
                            option.textContent = time;
                            editAppointmentTime.appendChild(option);
                        });
                        const local = info.event.start;
                        const hours = String(local.getHours()).padStart(2, '0');
                        const minutes = String(local.getMinutes()).padStart(2, '0');
                        editAppointmentTime.value = `${hours}:${minutes}`;
                    });

                    editAppointmentForm.action = `/appointments/${selectedEventId}/edit`;
                    deleteAppointmentForm.action = `/appointments/${selectedEventId}`;

                    editModal.classList.remove('hidden');
                }
            });
            calendar.render();

            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            closeEditModal.addEventListener('click', function() {
                editModal.classList.add('hidden');
            });

            branchSelect.addEventListener('change', updateTimeOptions);
            dateInput.addEventListener('change', updateTimeOptions);

            async function updateTimeOptions() {
                const date = dateInput.value;
                const branchId = branchSelect.value;
                timeSelect.innerHTML = '<option value="">Select Time</option>';
                if (!date || !branchId) return;
                const availableTimes = await fetchAvailableTimes(date, branchId);
                availableTimes.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                });
            }

            editBranchSelect.addEventListener('change', updateEditTimeOptions);
            editAppointmentDate.addEventListener('change', updateEditTimeOptions);

            async function updateEditTimeOptions() {
                const date = editAppointmentDate.value;
                const branchId = editBranchSelect.value;
                if (!date || !branchId) return;
                const availableTimes = await fetchAvailableTimes(date, branchId, selectedEventId);
                editAppointmentTime.innerHTML = '<option value="">Select Time</option>';
                availableTimes.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    editAppointmentTime.appendChild(option);
                });
            }

            deleteAppointmentBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this appointment?')) {
                    deleteAppointmentForm.submit();
                }
            });
        });
    </script>
</x-app-layout>