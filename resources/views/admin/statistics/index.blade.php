<x-admin-layout>
    <div class="max-w-6xl mx-auto py-10 space-y-8">

        <h2 class="text-3xl font-bold mt-5 mb-8 text-center text-gray-800">Order & Sales Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-xl shadow text-center border-t-4 border-green-400">
                <div class="text-4xl font-extrabold text-green-600">{{ $orderCounts['successful'] }}</div>
                <div class="text-gray-600 mt-2 font-semibold">Successful Orders</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow text-center border-t-4 border-red-400">
                <div class="text-4xl font-extrabold text-red-600">{{ $orderCounts['failed'] }}</div>
                <div class="text-gray-600 mt-2 font-semibold">Failed Orders</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow text-center border-t-4 border-yellow-400">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $orderCounts['pending'] }}</div>
                <div class="text-gray-600 mt-2 font-semibold">Pending Orders</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <h3 class="text-xl font-bold text-gray-700">Order Overview</h3>
                <div>
                    <label for="orders-interval" class="font-semibold mr-2">Show orders by:</label>
                    <select id="orders-interval" class="border border-gray-300 rounded px-2 py-1 focus:ring focus:ring-teal-200">
                        <option value="total" selected>Total</option>
                        <option value="week">Day of Week</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select>
                </div>
            </div>
            <canvas id="ordersChart" height="100"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <h3 class="text-xl font-bold text-gray-700">Sales (₱)</h3>
                <div>
                    <label for="sales-interval" class="font-semibold mr-2">Show sales by:</label>
                    <select id="sales-interval" class="border border-gray-300 rounded px-2 py-1 focus:ring focus:ring-teal-200">
                        <option value="month" selected>Month</option>
                        <option value="week">Day of Week</option>
                        <option value="year">Year</option>
                    </select>
                </div>
            </div>
            <canvas id="salesChart" height="100"></canvas>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-xl shadow text-center border-t-4 border-teal-400">
                <div class="text-3xl font-bold text-teal-700">₱{{ number_format($totalIncome, 2) }}</div>
                <div class="text-gray-600 mt-2 font-semibold">Total Income</div>
            </div>
            <a href="{{ route('user.index') }}" class="bg-white p-8 rounded-xl shadow text-center border-t-4 border-blue-400 transition hover:shadow-lg hover:bg-blue-50 cursor-pointer block">
                <div class="text-3xl font-bold">{{ $userCount }}</div>
                <div class="text-gray-600 mt-2 font-semibold">Total Users</div>
            </a>
            <a href="#" class="bg-white p-8 rounded-xl shadow text-center border-t-4 border-purple-400 transition hover:shadow-lg hover:bg-purple-50 cursor-pointer block">
                <div class="text-3xl font-bold">{{ $productCount }}</div>
                <div class="text-gray-600 mt-2 font-semibold">Total Products</div>
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
                            'rgba(34,197,94,0.7)',
                            'rgba(239,68,68,0.7)',
                            'rgba(251,191,36,0.7)'
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
                            backgroundColor: 'rgba(34,197,94,0.7)'
                        },
                        {
                            label: 'Failed',
                            data: orderStatusCounts[interval].failed,
                            backgroundColor: 'rgba(239,68,68,0.7)'
                        },
                        {
                            label: 'Pending',
                            data: orderStatusCounts[interval].pending,
                            backgroundColor: 'rgba(251,191,36,0.7)'
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
                    borderColor: 'rgba(16,185,129,1)',
                    backgroundColor: 'rgba(16,185,129,0.2)',
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
            salesChart.config.type = (currentInterval === 'week') ? 'bar' : 'line';
            salesChart.update();
        });
    </script>
</x-admin-layout>