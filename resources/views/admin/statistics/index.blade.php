<x-admin-layout>
    <div class="max-w-6xl mx-auto py-10 space-y-8">
        <h2 class="text-3xl font-bold mt-5 mb-8 text-center text-[#3d405b]">Advanced Statistics Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <!-- Top 10 Products by Quantity Sold -->
            <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0]">
                <h3 class="text-xl text-center font-bold text-[#3d405b] mb-4">Top 10 Products by Quantity Sold</h3>
                <canvas id="productQuantityChart" height="120"></canvas>
            </div>
            <!-- Top 10 Products by Sales Amount -->
            <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0]">
                <h3 class="text-xl text-center font-bold text-[#3d405b] mb-4">Top 10 Products by Sales Amount</h3>
                <canvas id="productSalesChart" height="120"></canvas>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <!-- Monthly Revenue Trend -->
            <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0]">
                <h3 class="text-xl text-center font-bold text-[#3d405b] mb-4">Monthly Revenue (₱)</h3>
                <canvas id="monthlyRevenueChart" height="120"></canvas>
            </div>
            <!-- User Registrations per Month -->
            <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0]">
                <h3 class="text-xl text-center font-bold text-[#3d405b] mb-4">User Registrations per Month</h3>
                <canvas id="userRegistrationsChart" height="120"></canvas>
            </div>
        </div>
        <div class="bg-[#ffffff] rounded-xl shadow p-8 border border-[#ffd6e0] mt-8">
            <h3 class="text-xl text-center font-bold text-[#3d405b] mb-4">Order Status Distribution</h3>
            <canvas id="orderStatusPie" height="120"></canvas>
        </div>
    </div>

    <!-- Hidden div for passing JSON data to JS -->
    <div id="statistics-data"
        data-quantity-names='@json($quantityNames ?? [])'
        data-quantity-totals='@json($quantityTotals ?? [])'
        data-sales-names='@json($salesNames ?? [])'
        data-sales-totals='@json($salesTotals ?? [])'
        data-months='@json($months ?? [])'
        data-revenues='@json($revenues ?? [])'
        data-user-months='@json($userMonths ?? [])'
        data-user-counts='@json($userCounts ?? [])'
        data-status-counts='@json($statusCounts ?? [])'
        style="display:none"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get data from hidden div
        const statsDiv = document.getElementById('statistics-data');
        const quantityNames = JSON.parse(statsDiv.dataset.quantityNames || '[]');
        const quantityTotals = JSON.parse(statsDiv.dataset.quantityTotals || '[]');
        const salesNames = JSON.parse(statsDiv.dataset.salesNames || '[]');
        const salesTotals = JSON.parse(statsDiv.dataset.salesTotals || '[]');
        const months = JSON.parse(statsDiv.dataset.months || '[]');
        const revenues = JSON.parse(statsDiv.dataset.revenues || '[]');
        const userMonths = JSON.parse(statsDiv.dataset.userMonths || '[]');
        const userCounts = JSON.parse(statsDiv.dataset.userCounts || '[]');
        const statusCounts = JSON.parse(statsDiv.dataset.statusCounts || '{}');

        // Top 10 Products by Quantity Sold
        if (quantityNames.length) {
            new Chart(document.getElementById('productQuantityChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: quantityNames,
                    datasets: [{
                        label: 'Quantity Sold',
                        data: quantityTotals,
                        backgroundColor: '#ffd166',
                        borderColor: '#ffd166',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Quantity' } },
                        x: { title: { display: true, text: 'Product' } }
                    }
                }
            });
        }

        // Top 10 Products by Sales Amount
        if (salesNames.length) {
            new Chart(document.getElementById('productSalesChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: salesNames,
                    datasets: [{
                        label: 'Sales (₱)',
                        data: salesTotals,
                        backgroundColor: '#ef476f',
                        borderColor: '#ef476f',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Sales (₱)' } },
                        x: { title: { display: true, text: 'Product' } }
                    }
                }
            });
        }

        // Monthly Revenue Trend
        if (months.length) {
            new Chart(document.getElementById('monthlyRevenueChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Revenue (₱)',
                        data: revenues,
                        borderColor: '#118ab2',
                        backgroundColor: 'rgba(17,138,178,0.15)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: true } },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Revenue (₱)' } },
                        x: { title: { display: true, text: 'Month' } }
                    }
                }
            });
        }

        // User Registrations per Month
        if (userMonths.length) {
            new Chart(document.getElementById('userRegistrationsChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: userMonths,
                    datasets: [{
                        label: 'Registrations',
                        data: userCounts,
                        backgroundColor: '#06d6a0',
                        borderColor: '#06d6a0',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Users' } },
                        x: { title: { display: true, text: 'Month' } }
                    }
                }
            });
        }

        // Order Status Distribution Pie
        if (Object.keys(statusCounts).length) {
            new Chart(document.getElementById('orderStatusPie').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: Object.keys(statusCounts),
                    datasets: [{
                        data: Object.values(statusCounts),
                        backgroundColor: [
                            '#06d6a0', // successful
                            '#ef476f', // failed
                            '#ffd166', // pending
                            '#118ab2', // others
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
    </script>
</x-admin-layout>