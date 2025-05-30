<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class StatisticsController extends Controller
{
    public function index()
    {
        $orderCounts = [
            'successful' => Order::where('status', 'successful')->count(),
            'failed' => Order::where('status', 'failed')->count(),
            'pending' => Order::where('status', 'pending')->count(),
        ];

        $userCount = User::count();
        $productCount = Product::count();

        $totalIncome = Order::where('status', 'successful')->sum('order_total');
        $incomeByStatus = [
            'successful' => Order::where('status', 'successful')->sum('order_total'),
            'failed' => Order::where('status', 'failed')->sum('order_total'),
            'pending' => Order::where('status', 'pending')->sum('order_total'),
        ];

        $monthlyCounts = Order::select(
                DB::raw("DATE_FORMAT(purchase_date, '%Y-%m') as ym"),
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('ym', 'status')
            ->orderBy('ym')
            ->get();

        $monthLabels = [];
        $monthData = [];
        foreach ($monthlyCounts->groupBy('ym') as $ym => $group) {
            $monthLabels[] = date('F Y', strtotime($ym . '-01')); // "May 2025"
            $row = [
                'successful' => 0,
                'failed' => 0,
                'pending' => 0,
            ];
            foreach ($group as $item) {
                $row[$item->status] = $item->count;
            }
            $monthData[] = $row;
        }

        $yearlyCounts = Order::select(
                DB::raw("DATE_FORMAT(purchase_date, '%Y') as y"),
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('y', 'status')
            ->orderBy('y')
            ->get();

        $yearLabels = [];
        $yearData = [];
        foreach ($yearlyCounts->groupBy('y') as $y => $group) {
            $yearLabels[] = $y;
            $row = [
                'successful' => 0,
                'failed' => 0,
                'pending' => 0,
            ];
            foreach ($group as $item) {
                $row[$item->status] = $item->count;
            }
            $yearData[] = $row;
        }

        $weeklyCounts = Order::select(
                DB::raw("DAYOFWEEK(purchase_date) as weekday"),
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('weekday', 'status')
            ->orderBy('weekday')
            ->get();

        $weekdayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $weekLabels = $weekdayNames;
        $weekData = [];
        foreach (range(1, 7) as $i) {
            $row = [
                'successful' => 0,
                'failed' => 0,
                'pending' => 0,
            ];
            $group = $weeklyCounts->where('weekday', $i);
            foreach ($group as $item) {
                $row[$item->status] = $item->count;
            }
            $weekData[] = $row;
        }

        $orderStatusCounts = [
            'month' => [
                'labels' => $monthLabels,
                'successful' => array_column($monthData, 'successful'),
                'failed' => array_column($monthData, 'failed'),
                'pending' => array_column($monthData, 'pending'),
            ],
            'year' => [
                'labels' => $yearLabels,
                'successful' => array_column($yearData, 'successful'),
                'failed' => array_column($yearData, 'failed'),
                'pending' => array_column($yearData, 'pending'),
            ],
            'week' => [
                'labels' => $weekLabels,
                'successful' => array_column($weekData, 'successful'),
                'failed' => array_column($weekData, 'failed'),
                'pending' => array_column($weekData, 'pending'),
            ],
            'total' => $orderCounts,
        ];

        $monthlySales = Order::where('status', 'successful')
            ->select(DB::raw("DATE_FORMAT(purchase_date, '%Y-%m') as label"), DB::raw('SUM(order_total) as total'))
            ->groupBy('label')->orderBy('label')->get();

        $yearlySales = Order::where('status', 'successful')
            ->select(DB::raw("DATE_FORMAT(purchase_date, '%Y') as label"), DB::raw('SUM(order_total) as total'))
            ->groupBy('label')->orderBy('label')->get();

        $weeklySales = Order::where('status', 'successful')
            ->selectRaw("DAYOFWEEK(purchase_date) as weekday, SUM(order_total) as total")
            ->groupBy('weekday')->orderBy('weekday')->get();

        $weekTotals = [];
        foreach (range(1, 7) as $i) {
            $found = $weeklySales->firstWhere('weekday', $i);
            $weekTotals[] = $found ? $found->total : 0;
        }

        $salesData = [
            'month' => [
                'labels' => $monthLabels,
                'totals' => $monthlySales->pluck('total'),
            ],
            'week' => [
                'labels' => $weekLabels,
                'totals' => $weekTotals,
            ],
            'year' => [
                'labels' => $yearLabels,
                'totals' => $yearlySales->pluck('total'),
            ],
        ];

        return view('admin.home', compact(
            'orderCounts',
            'userCount',
            'productCount',
            'totalIncome',
            'incomeByStatus',
            'salesData',
            'orderStatusCounts'
        ));
    }

    public function extraDetails()
    {
        // Top 10 Products by Quantity Sold
        $topByQuantity = \App\Models\Order::where('orders.status', 'successful')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->select(
                'products.product_name',
                DB::raw('SUM(order_details.quantity) as total_quantity')
            )
            ->groupBy('products.product_name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        $quantityNames = $topByQuantity->pluck('product_name');
        $quantityTotals = $topByQuantity->pluck('total_quantity');

        // Top 10 Products by Sales Amount (using products.price)
        $topBySales = \App\Models\Order::where('orders.status', 'successful')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->select(
                'products.product_name',
                DB::raw('SUM(order_details.quantity * products.price) as total_sales')
            )
            ->groupBy('products.product_name', 'products.price')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        $salesNames = $topBySales->pluck('product_name');
        $salesTotals = $topBySales->pluck('total_sales');

        // Monthly Revenue Trend (last 12 months)
        $monthlyRevenue = \App\Models\Order::select(
                DB::raw("DATE_FORMAT(purchase_date, '%Y-%m') as month"),
                DB::raw('SUM(order_total) as revenue')
            )
            ->where('status', 'successful')
            ->where('purchase_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = $monthlyRevenue->pluck('month');
        $revenues = $monthlyRevenue->pluck('revenue');

        // User Registrations per Month (last 12 months)
        $userRegistrations = \App\Models\User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $userMonths = $userRegistrations->pluck('month');
        $userCounts = $userRegistrations->pluck('count');

        // Order Status Distribution (Pie Chart)
        $statusCounts = \App\Models\Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.statistics.index', [
            // By quantity
            'quantityNames' => $quantityNames,
            'quantityTotals' => $quantityTotals,
            // By sales
            'salesNames' => $salesNames,
            'salesTotals' => $salesTotals,
            // Other stats
            'months' => $months,
            'revenues' => $revenues,
            'userMonths' => $userMonths,
            'userCounts' => $userCounts,
            'statusCounts' => $statusCounts,
        ]);
    }


}