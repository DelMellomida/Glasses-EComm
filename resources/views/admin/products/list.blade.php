<x-admin-layout>
    <div class="flex h-screen bg-gradient-to-br from-[#ffe5ec] to-[#b8c6db]">
        <div class="flex-1 flex items-start justify-center py-12">
            <div class="w-full max-w-5xl mx-auto bg-[#ffffff] rounded-xl shadow-lg p-6 mt-12 border border-[#ffd6e0]">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.product.create') }}"
                       class="bg-[#055970] hover:bg-[#ffd166] text-white hover:text-[#ffffff] font-bold py-2 px-4 rounded transition border border-[#055970] hover:border-[#ffd166] shadow">
                        + Add Product
                    </a>
                </div>
                <div class="overflow-x-auto">
                <table id="product_list" class="min-w-full w-full table-auto rounded-lg overflow-hidden custom-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#055970] text-[#ffffff] uppercase tracking-wider border-b-2 border-[#055970]">Images</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#055970] text-[#ffffff] uppercase tracking-wider border-b-2 border-[#055970]">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#055970] text-[#ffffff] uppercase tracking-wider border-b-2 border-[#055970]">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#055970] text-[#ffffff] uppercase tracking-wider border-b-2 border-[#055970]">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#055970] text-[#ffffff] uppercase tracking-wider border-b-2 border-[#055970]">Gender</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#055970] text-[#ffffff] uppercase tracking-wider border-b-2 border-[#055970]">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold bg-[#055970] text-[#ffffff] uppercase tracking-wider border-b-2 border-[#055970]">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate rows here -->
                    </tbody>
                </table>
                </div> 
            </div>
        </div>
    </div>

    <style>
        #product_list tbody tr:nth-child(even) {
            background-color: #ededed !important;
        }
        #product_list tbody tr:nth-child(odd) {
            background-color: #ffffff !important;
        }
        #product_list tbody tr {
            color: #3d405b !important;
            border-bottom: 1px solid #ffd6e0 !important;
        }
        #product_list tbody tr:hover {
            background-color: #b6d8e2 !important;
            transition: background 0.2s;
        }
        #product_list th, #product_list td {
            border-radius: 6px;
            border: 1px solid #ffd6e0;
        }
        #product_list {
            border-radius: 12px;
            overflow: hidden;
            background: transparent;
        }
        .dataTables_length select {
            min-width: 5rem !important;
            width: 5rem !important;
            padding-right: 2rem;
            background: #ffd6e0;
            color: #3d405b;
            border: 1px solid #ef476f;
            border-radius: 6px;
        }
        .dataTables_filter label {
            color: #3d405b !important;
        }
        .dataTables_filter input {
            background: #ffffff !important;
            color: #3d405b !important;
            border: 1px solid #055970 !important;
            border-radius: 6px;
            padding: 0.5rem 1rem;
        }
        .dataTables_info {
            color: #3d405b !important;
        }
        .dt-button, .dt-buttons .btn {
            background: #055970 !important;
            color: #fff !important;
            border-radius: 6px !important;
            border: 1px solid #055970 !important;
            margin-right: 0.5rem;
        }
        .dt-button:hover, .dt-buttons .btn:hover {
            background: #055970 !important;
            color: #ffffff !important;
            border: 1px solid #055970 !important;
        }
    </style>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#product_list').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('admin.list-products') }}",
                },
                columns: [
                    { data: "images", name: "images", orderable: false, searchable: false, responsivePriority: 5 },
                    { data: "product_name", name: "product_name", responsivePriority: 1 },
                    { data: "product_description", name: "product_description", responsivePriority: 3 },
                    { data: "price", name: "price" , responsivePriority: 2 },
                    { data: "gender", name: "gender" , responsivePriority: 4 },
                    { data: "status", name: "status" , responsivePriority: 1 },
                    { data: "action", name: "action", orderable: false, searchable: false , responsivePriority: 1 }
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
                    $(row).attr('data-edit-url', '/admin/products/' + data.product_id + '/edit');
                    $(row).addClass('cursor-pointer transition');
                },
                drawCallback: function() {
                    $('#product_list').addClass('table-auto w-full');
                    var $filter = $('.dataTables_filter');
                    var $buttons = $('.dt-buttons');
                    $filter.css('display', 'flex').css('align-items', 'center').css('gap', '12px').addClass('mb-2');
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

            // Row click for edit (except on action buttons)
            $('#product_list tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button,form,a').length === 0) {
                    var url = $(this).attr('data-edit-url');
                    if (url) {
                        var backUrl = encodeURIComponent(window.location.href);
                        window.location.href = url + '?back=' + backUrl;
                    }
                }
            });

            // Optional: handle image click to preview
            $(document).on('click', '.product-image-thumb', function(e) {
                e.stopPropagation();
                let src = $(this).data('src');
                window.open(src, '_blank');
            });
        });
    </script>
    @endpush
</x-admin-layout>