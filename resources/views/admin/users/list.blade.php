<x-admin-layout>
    <div class="flex h-screen">
        <div class="flex-1 flex items-start justify-center py-12">
            <div class="w-full max-w-5xl mx-auto bg-[#1E293B] rounded-xl shadow-lg p-6 mt-12">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.user.create') }}"
                       class="bg-[#38BDF8] hover:bg-[#0E7490] text-white font-bold py-2 px-4 rounded transition">
                        + Add User
                    </a>
                </div>
                <table id="user_list" class="min-w-full w-full table-auto rounded-lg overflow-hidden custom-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#164E63] text-[#F1F5F9] uppercase tracking-wider border-b-2 border-[#38BDF8]">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#164E63] text-[#F1F5F9] uppercase tracking-wider border-b-2 border-[#38BDF8]">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#164E63] text-[#F1F5F9] uppercase tracking-wider border-b-2 border-[#38BDF8]">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate rows here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Improved DataTable styling */
        #user_list tbody tr:nth-child(even) {
            background-color: #155E75 !important;
        }
        #user_list tbody tr:nth-child(odd) {
            background-color: #1E293B !important;
        }
        #user_list tbody tr {
            color: #E0F2FE !important;
            border-bottom: 1px solid #38BDF8 !important;
        }
        #user_list tbody tr:hover {
            background-color: #0E7490 !important;
            transition: background 0.2s;
        }
        #user_list th, #user_list td {
            border-radius: 6px;
            border: 1px solid rgba(56,189,248,0.15);
        }
        #user_list {
            border-radius: 12px;
            overflow: hidden;
        }
        #user_list tbody tr:nth-child(even) {
            background-color: #155E75 !important;
        }
        /* ...existing code... */
        .dataTables_length select {
            min-width: 5rem !important;
            width: 5rem !important;
            padding-right: 2rem; /* space for the arrow */
        }
    </style>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#user_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.list-users') }}",
                },
                columns: [
                    { data: "name", name: "name" },
                    { data: "email", name: "email" },
                    { data: "action", name: "action", orderable: false, searchable: false }
                ],
                dom: 'lfrtipB', // <-- This puts filter and buttons in the same row
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Export',
                        className: 'bg-[#164E63] text-white px-4 py-2 rounded mr-2',
                        buttons: [
                            {
                                extend: 'csvHtml5',
                                text: 'CSV',
                                className: 'bg-[#164E63] text-white px-4 py-2 rounded mb-2'
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                className: 'bg-[#164E63] text-white px-4 py-2 rounded'
                            }
                        ]
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-edit-url', '/admin/users/' + data.id + '/edit');
                    $(row).addClass('cursor-pointer transition');
                },
                drawCallback: function() {
                    $('#user_list').addClass('table-auto w-full');
                    // Move export button next to search bar
                    var $filter = $('.dataTables_filter');
                    var $buttons = $('.dt-buttons');
                    $filter.css('display', 'flex').css('align-items', 'center').css('gap', '12px').addClass('mb-2');
                    $buttons.css('margin-bottom', '0');
                    $buttons.find('button').addClass('bg-[#164E63] text-white px-4 py-2 rounded');
                    // Only move if not already moved
                    if ($buttons.parent()[0] !== $filter[0]) {
                        $filter.append($buttons);
                    }
                    $('.dataTables_filter label').addClass('text-white mr-2');
                    $('.dataTables_filter input')
                        .addClass('bg-[#164E63] text-white border border-[#38BDF8] rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400')
                        .css('margin-left', '12px');
                    $('.dataTables_length label').addClass('text-white');
                    $('.dataTables_length select').addClass('bg-[#164E63] text-white border border-[#38BDF8] rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-sky-400');
                    $('.dataTables_info').addClass('text-white');
                }
            });

            // Row click for edit
            $('#user_list tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button,form').length === 0) {
                    var url = $(this).attr('data-edit-url');
                    if (url) {
                        var backUrl = encodeURIComponent(window.location.href);
                        window.location.href = url + '?back=' + backUrl;
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>