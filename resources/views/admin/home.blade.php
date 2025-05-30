<x-admin-layout>
    <div class="max-w-6xl mx-auto py-10 space-y-8">

        <h2 class="text-3xl font-bold mt-5 mb-8 text-center text-[#3d405b]">Order & Sales Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-[#ffffff] p-8 rounded-xl shadow text-center border-dashed">
                <div class="text-4xl font-extrabold text-[#06d6a0]">{{ $orderCounts['successful'] }}</div>
                <div class="text-[#3d405b] mt-2 font-semibold">Successful Orders</div>
            </div>
            <div class="bg-[#ffffff] p-8 rounded-xl shadow text-center border-t-4 border-[#ef476f]">
                <div class="text-4xl font-extrabold text-[#ef476f]">{{ $orderCounts['failed'] }}</div>
                <div class="text-[#3d405b] mt-2 font-semibold">Failed Orders</div>
            </div>
            <div class="bg-[#ffffff] p-8 rounded-xl shadow text-center border-t-4 border-[#ffd166]">
                <div class="text-4xl font-extrabold text-[#ffd166]">{{ $orderCounts['pending'] }}</div>
                <div class="text-[#3d405b] mt-2 font-semibold">Pending Orders</div>
            </div>
        </div>

        <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0]">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <h3 class="text-xl font-bold text-[#3d405b]">Order Overview</h3>
                <div>
                    <label for="orders-interval" class="font-semibold mr-2 text-[#3d405b]">Show orders by:</label>
                    <select id="orders-interval" class="border border-[#ef476f] rounded px-2 py-1 focus:ring focus:ring-[#ffd166] bg-[#ffd6e0] text-[#3d405b]">
                        <option value="total" selected>Total</option>
                        <option value="week">Day of Week</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select>
                </div>
            </div>
            <canvas id="ordersChart" height="100"></canvas>
        </div>

        <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0]">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <h3 class="text-xl font-bold text-[#3d405b]">Sales (₱)</h3>
                <div>
                    <label for="sales-interval" class="font-semibold mr-2 text-[#3d405b]">Show sales by:</label>
                    <select id="sales-interval" class="border border-[#ef476f] rounded px-2 py-1 focus:ring focus:ring-[#ffd166] bg-[#ffd6e0] text-[#3d405b]">
                        <option value="month" selected>Month</option>
                        <option value="week">Day of Week</option>
                        <option value="year">Year</option>
                    </select>
                </div>
            </div>
            <canvas id="salesChart" height="100"></canvas>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-[#ffffff] p-8 rounded-xl shadow text-center border-t-4 border-[#118ab2]">
                <div class="text-3xl font-bold text-[#118ab2]">₱{{ number_format($totalIncome, 2) }}</div>
                <div class="text-[#3d405b] mt-2 font-semibold">Total Income</div>
            </div>
            <a href="{{ route('user.index') }}" class="bg-[#ffffff] p-8 rounded-xl shadow text-center border-t-4 border-[#3d405b] transition hover:shadow-lg hover:bg-[#f8edeb] cursor-pointer block">
                <div class="text-3xl font-bold text-[#3d405b]">{{ $userCount }}</div>
                <div class="text-[#3d405b] mt-2 font-semibold">Total Users</div>
            </a>
            <a href="#" class="bg-[#ffffff] p-8 rounded-xl shadow text-center border-t-4 border-[#b8c6db] transition hover:shadow-lg hover:bg-[#f8edeb] cursor-pointer block">
                <div class="text-3xl font-bold text-[#b8c6db]">{{ $productCount }}</div>
                <div class="text-[#3d405b] mt-2 font-semibold">Total Products</div>
            </a>
        </div>
    </div>

    <div id="sales-data"
        data-sales='@json($salesData)'
        data-order-status-counts='@json($orderStatusCounts)'
        data-order-counts='@json([
            $orderCounts["successful"] ?? 0,
            $orderCounts["failed"] ?? 0,
            $orderCounts["pending"] ?? 0
        ])'
        data-income-status='@json([
            $incomeByStatus["successful"] ?? 0,
            $incomeByStatus["failed"] ?? 0,
            $incomeByStatus["pending"] ?? 0
        ])'
        style="display:none"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesData = JSON.parse(document.getElementById('sales-data').dataset.sales);
        const orderStatusCounts = JSON.parse(document.getElementById('sales-data').dataset.orderStatusCounts);
        const orderCounts = JSON.parse(document.getElementById('sales-data').dataset.orderCounts);
        const incomeByStatus = JSON.parse(document.getElementById('sales-data').dataset.incomeStatus);

        function getOrderChartData(interval) {
            if (interval === 'total') {
                return {
                    labels: ['Successful', 'Failed', 'Pending'],
                    datasets: [{
                        label: 'Orders',
                        data: [
                            orderStatusCounts.total.successful,
                            orderStatusCounts.total.failed,
                            orderStatusCounts.total.pending
                        ],
                        backgroundColor: [
                            '#06d6a0',
                            '#ef476f',
                            '#ffd166'
                        ]
                    }]
                };
            } else {
                return {
                    labels: orderStatusCounts[interval].labels,
                    datasets: [
                        {
                            label: 'Successful',
                            data: orderStatusCounts[interval].successful,
                            backgroundColor: '#06d6a0'
                        },
                        {
                            label: 'Failed',
                            data: orderStatusCounts[interval].failed,
                            backgroundColor: '#ef476f'
                        },
                        {
                            label: 'Pending',
                            data: orderStatusCounts[interval].pending,
                            backgroundColor: '#ffd166'
                        }
                    ]
                };
            }
        }

        let ordersInterval = 'total';
        const ordersChartCtx = document.getElementById('ordersChart').getContext('2d');
        let ordersChart = new Chart(ordersChartCtx, {
            type: 'bar',
            data: getOrderChartData(ordersInterval),
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, title: { display: true, text: 'Orders' } } }
            }
        });

        document.getElementById('orders-interval').addEventListener('change', function() {
            ordersInterval = this.value;
            ordersChart.data = getOrderChartData(ordersInterval);
            ordersChart.update();
        });

        let currentInterval = 'month';
        const salesChartCtx = document.getElementById('salesChart').getContext('2d');
        let salesChart = new Chart(salesChartCtx, {
            type: 'line',
            data: {
                labels: salesData[currentInterval].labels,
                datasets: [{
                    label: 'Sales (₱)',
                    data: salesData[currentInterval].totals,
                    borderColor: '#118ab2',
                    backgroundColor: 'rgba(17,138,178,0.15)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Sales (₱)' }
                    },
                    x: {
                        title: { display: true, text: 'Date' }
                    }
                }
            }
        });

        document.getElementById('sales-interval').addEventListener('change', function() {
            currentInterval = this.value;
            salesChart.data.labels = salesData[currentInterval].labels;
            salesChart.data.datasets[0].data = salesData[currentInterval].totals;

            if (currentInterval === 'week') {
                salesChart.config.type = 'bar';
                salesChart.data.datasets[0].backgroundColor = '#ef476f'; // Retro pink for bars
                salesChart.data.datasets[0].borderColor = '#ef476f';
                salesChart.data.datasets[0].fill = false;
                salesChart.data.datasets[0].tension = 0;
            } else {
                salesChart.config.type = 'line';
                salesChart.data.datasets[0].backgroundColor = 'rgba(17,138,178,0.15)';
                salesChart.data.datasets[0].borderColor = '#118ab2';
                salesChart.data.datasets[0].fill = true;
                salesChart.data.datasets[0].tension = 0.3;
            }
            salesChart.update();
        });
    </script>
</x-admin-layout>