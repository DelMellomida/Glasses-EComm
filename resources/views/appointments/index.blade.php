<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">My Appointments</h2>
        <div id="calendar"></div>
    </div>

    <!-- Modal for booking -->
    <div id="appointment-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Book Appointment</h3>
            <form id="appointment-form" method="POST" action="{{ route('appointments.store') }}">
                @csrf
                <input type="hidden" name="appointment_date" id="appointment_date">
                <div class="mb-4">
                    <label for="appointment_time" class="block font-medium mb-1">Time</label>
                    <input type="time" name="appointment_time" id="appointment_time" class="border rounded px-3 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="block font-medium mb-1">Type</label>
                    <input type="text" name="type" id="type" class="border rounded px-3 py-2 w-full" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="close-modal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" style="background-color:#2563eb!important;color:white!important;padding:0.5rem 1rem!important;border-radius:0.375rem!important;" class="hover:bg-blue-700">Book</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add this modal after your booking modal -->
    <div id="edit-appointment-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Edit Appointment</h3>
            <form id="edit-appointment-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="appointment_id" id="edit_appointment_id">
                <div class="mb-4">
                    <label for="edit_appointment_time" class="block font-medium mb-1">Time</label>
                    <input type="time" name="appointment_time" id="edit_appointment_time" class="border rounded px-3 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="edit_type" class="block font-medium mb-1">Type</label>
                    <input type="text" name="type" id="edit_type" class="border rounded px-3 py-2 w-full" required>
                </div>
                <div class="flex justify-between space-x-2">
                    <button type="button" id="delete-appointment" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                    <div>
                        <button type="button" id="close-edit-modal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('appointment-modal');
            const closeModal = document.getElementById('close-modal');
            const dateInput = document.getElementById('appointment_date');

            // Edit modal elements
            const editModal = document.getElementById('edit-appointment-modal');
            const closeEditModal = document.getElementById('close-edit-modal');
            const editAppointmentId = document.getElementById('edit_appointment_id');
            const editAppointmentTime = document.getElementById('edit_appointment_time');
            const editType = document.getElementById('edit_type');
            const deleteBtn = document.getElementById('delete-appointment');

            let selectedEventId = null;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: "{{ route('appointments.json') }}",
                select: function(info) {
                    modal.classList.remove('hidden');
                    dateInput.value = info.startStr;
                },
                eventClick: function(info) {
                    // Show edit modal with event data
                    selectedEventId = info.event.id;
                    editAppointmentId.value = info.event.id;
                    const local = info.event.start;
                    const hours = String(local.getHours()).padStart(2, '0');
                    const minutes = String(local.getMinutes()).padStart(2, '0');
                    editAppointmentTime.value = `${hours}:${minutes}`;
                    editType.value = info.event.title;
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

            // Handle update
            document.getElementById('edit-appointment-form').addEventListener('submit', function(e) {
                e.preventDefault();
                fetch(`/appointments/${selectedEventId}/edit`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        appointment_time: editAppointmentTime.value,
                        type: editType.value,
                        appointment_date: calendar.getEventById(selectedEventId).startStr.substring(0,10)
                    })
                }).then(res => {
                    if(res.ok) {
                        editModal.classList.add('hidden');
                        calendar.refetchEvents();
                    }
                });
            });

            // Handle delete
            deleteBtn.addEventListener('click', function() {
                if(confirm('Are you sure you want to delete this appointment?')) {
                    fetch(`/appointments/${selectedEventId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    }).then(res => {
                        if(res.ok) {
                            editModal.classList.add('hidden');
                            calendar.refetchEvents();
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>