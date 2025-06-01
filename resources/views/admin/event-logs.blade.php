<x-admin-layout>
    <div class="max-w-6xl mx-auto pt-24 pb-10"> <!-- Added mt-20 here -->
        <h2 class="text-3xl font-bold mb-8 text-center text-[#3d405b]">Event Logs</h2>
        <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0]">
            <table id="event_logs" class="min-w-full w-full table-auto rounded-lg overflow-hidden custom-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 bg-[#055970] text-[#ffffff] font-bold">Date</th>
                        <th class="px-4 py-2 bg-[#055970] text-[#ffffff] font-bold">User</th>
                        <th class="px-4 py-2 bg-[#055970] text-[#ffffff] font-bold">Type</th>
                        <th class="px-4 py-2 bg-[#055970] text-[#ffffff] font-bold">Description</th>
                        <!-- <th class="px-4 py-2 bg-[#055970] text-[#ffffff] font-bold">Data</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        @php
                            $jsonData = json_encode($log->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                            $isLong = strlen($jsonData) > 400;
                        @endphp
                        <tr>
                            <td class="px-4 py-2">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2">{{ $log->user?->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $log->event_type }}</td>
                            <td class="px-4 py-2">{{ $log->description }}</td>
                            <!-- <td class="px-4 py-2 align-top">
                                <div class="relative">
                                    <div class="event-log-data-preview" style="max-height: 90px; overflow: auto; background: #ffd6e0; border-radius: 6px; padding: 8px; font-size: 0.85rem; font-family: 'Fira Mono', 'Consolas', monospace; word-break: break-all;">
                                        {{ $isLong ? Str::limit($jsonData, 400, '...') : $jsonData }}
                                    </div>
                                    @if($isLong)
                                        <button type="button" class="show-more-btn text-xs text-[#ef476f] underline mt-1" onclick="toggleLogData(this)">Show More</button>
                                        <div class="event-log-data-full hidden" style="background: #ffffff; border-radius: 6px; padding: 8px; font-size: 0.85rem; font-family: 'Fira Mono', 'Consolas', monospace; word-break: break-all; margin-top: 4px; max-height: 300px; overflow: auto;">
                                            {{ $jsonData }}
                                        </div>
                                    @endif
                                </div>
                            </td> -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <style>
        .event-log-data-preview, .event-log-data-full {
            white-space: pre-line;
            word-break: break-all;
        }
    </style>

    @push('scripts')
    <script>
        function toggleLogData(btn) {
            const preview = btn.previousElementSibling;
            const full = btn.nextElementSibling;
            if (full.classList.contains('hidden')) {
                full.classList.remove('hidden');
                btn.textContent = 'Show Less';
                preview.style.display = 'none';
            } else {
                full.classList.add('hidden');
                btn.textContent = 'Show More';
                preview.style.display = '';
            }
        }

        $(document).ready(function() {
            $('#event_logs').DataTable({
                paging: false,
                info: false,
                order: [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    'csvHtml5', 'excelHtml5', 'print'
                ]
            });
        });
    </script>
    @endpush
</x-admin-layout>