<x-admin-layout>
    <div class="flex h-screen">
        <!-- Sidebar is already handled by the layout -->

        <div class="flex-1 flex items-start justify-center py-12">
            <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-6 mt-12">
                <table id="inventory_list" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Product Image</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- DataTables will populate rows here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#inventory_list').DataTable({
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
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-edit-url', '/admin/users/' + data.id + '/edit');
                    $(row).addClass('cursor-pointer hover:bg-teal-50 transition');
                },
                drawCallback: function() {
                    $('#inventory_list').addClass('table-auto w-full');
                    $('#inventory_list thead').addClass('bg-gray-50');
                    $('#inventory_list tbody tr').addClass('hover:bg-gray-100');
                    $('.dataTables_filter input').addClass('bg-white text-gray-700 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500');
                    $('.dataTables_length select').addClass('bg-white text-gray-700 border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500');
                }
            });

            // Row click for edit
            $('#inventory_list tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button,form').length === 0) {
                    var url = $(this).attr('data-edit-url');
                    if (url) {
                        // Add ?back=... to the edit URL
                        var backUrl = encodeURIComponent(window.location.href);
                        window.location.href = url + '?back=' + backUrl;
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>