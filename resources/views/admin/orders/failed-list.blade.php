<x-admin-layout>
    <div class="flex h-screen bg-gradient-to-br from-[#ffe5ec] to-[#b8c6db]">
        <div class="flex-1 flex items-start justify-center py-12">
            <div class="w-full max-w-5xl mx-auto bg-[#fff1f1] rounded-xl shadow-lg p-6 mt-12 border border-[#ffd6e0]">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.transaction.create') }}"
                       class="bg-[#ef476f] hover:bg-[#ffd166] text-white hover:text-[#3d405b] font-bold py-2 px-4 rounded transition border border-[#ef476f] hover:border-[#ffd166] shadow">
                        + Add Transaction
                    </a>
                </div>
                <table id="failed_transactions_list" class="min-w-full w-full table-auto rounded-lg overflow-hidden custom-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#ffd6e0] text-[#3d405b] uppercase tracking-wider border-b-2 border-[#ef476f]">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#ffd6e0] text-[#3d405b] uppercase tracking-wider border-b-2 border-[#ef476f]">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#ffd6e0] text-[#3d405b] uppercase tracking-wider border-b-2 border-[#ef476f]">Purchase Date</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#ffd6e0] text-[#3d405b] uppercase tracking-wider border-b-2 border-[#ef476f]">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#ffd6e0] text-[#3d405b] uppercase tracking-wider border-b-2 border-[#ef476f]">Action</th>
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
        #failed_transactions_list tbody tr:nth-child(even) { background-color: #ffe5ec !important; }
        #failed_transactions_list tbody tr:nth-child(odd) { background-color: #fff1f1 !important; }
        #failed_transactions_list tbody tr { color: #3d405b !important; border-bottom: 1px solid #ffd6e0 !important; }
        #failed_transactions_list tbody tr:hover { background-color: #ffd6e0 !important; transition: background 0.2s; }
        #failed_transactions_list th, #failed_transactions_list td { border-radius: 6px; border: 1px solid #ffd6e0; }
        #failed_transactions_list { border-radius: 12px; overflow: hidden; background: transparent; }
        .dataTables_length select {
            min-width: 5rem !important; width: 5rem !important; padding-right: 2rem;
            background: #ffd6e0; color: #3d405b; border: 1px solid #ef476f; border-radius: 6px;
        }
        .dataTables_filter label { color: #3d405b !important; }
        .dataTables_filter input {
            background: #ffd6e0 !important; color: #3d405b !important;
            border: 1px solid #ef476f !important; border-radius: 6px; padding: 0.5rem 1rem;
        }
        .dataTables_info { color: #3d405b !important; }
        .dt-button, .dt-buttons .btn {
            background: #ef476f !important; color: #fff !important; border-radius: 6px !important;
            border: 1px solid #ef476f !important; margin-right: 0.5rem;
        }
        .dt-button:hover, .dt-buttons .btn:hover {
            background: #ffd166 !important; color: #3d405b !important; border: 1px solid #ffd166 !important;
        }
    </style>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#failed_transactions_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.failed-transactions') }}",
                },
                columns: [
                    { data: "order_id", name: "order_id" },
                    { data: "order_total", name: "order_total" },
                    { data: "purchase_date", name: "purchase_date" },
                    { data: "status", name: "status" },
                    { data: "action", name: "action", orderable: false, searchable: false }
                ],
                dom: 'lfrtipB',
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Export',
                        className: 'bg-[#ef476f] text-white px-4 py-2 rounded mr-2',
                        buttons: [
                            {
                                extend: 'csvHtml5',
                                text: 'CSV',
                                className: 'bg-[#ef476f] text-white px-4 py-2 rounded mb-2'
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                className: 'bg-[#ef476f] text-white px-4 py-2 rounded'
                            }
                        ]
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-edit-url', '/admin/transaction/' + data.order_id + '/edit');
                    $(row).addClass('cursor-pointer transition');
                },
                drawCallback: function() {
                    $('#failed_transactions_list').addClass('table-auto w-full');
                    var $filter = $('.dataTables_filter');
                    var $buttons = $('.dt-buttons');
                    $filter.css('display', 'flex').css('align-items', 'center').css('gap', '12px').css('margin-bottom', '1rem');
                    $buttons.css('margin-bottom', '0');
                    $buttons.find('button').addClass('bg-[#ef476f] text-white px-4 py-2 rounded');
                    if ($buttons.parent()[0] !== $filter[0]) {
                        $filter.append($buttons);
                    }
                    $('.dataTables_filter label').addClass('text-[#3d405b] mr-2');
                    $('.dataTables_filter input')
                        .addClass('bg-[#ffd6e0] text-[#3d405b] border border-[#ef476f] rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffd166]')
                        .css('margin-left', '12px');
                    $('.dataTables_length label').addClass('text-[#3d405b]');
                    $('.dataTables_length select').addClass('bg-[#ffd6e0] text-[#3d405b] border border-[#ef476f] rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-[#ffd166]');
                    $('.dataTables_info').addClass('text-[#3d405b]');
                }
            });

            // Row click for edit
            $('#failed_transactions_list tbody').on('click', 'tr', function(e) {
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