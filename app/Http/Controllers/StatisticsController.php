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
        // Order counts by status (total)
        $orderCounts = [
            'successful' => Order::where('status', 'successful')->count(),
            'failed' => Order::where('status', 'failed')->count(),
            'pending' => Order::where('status', 'pending')->count(),
        ];

        // User and product counts
        $userCount = User::count();
        $productCount = Product::count();

        // Total income and income by status
        $totalIncome = Order::where('status', 'successful')->sum('order_total');
        $incomeByStatus = [
            'successful' => Order::where('status', 'successful')->sum('order_total'),
            'failed' => Order::where('status', 'failed')->sum('order_total'),
            'pending' => Order::where('status', 'pending')->sum('order_total'),
        ];

        // --- Order counts by interval and status ---

        // Monthly counts
        $monthlyCounts = Order::select(
                DB::raw("DATE_FORMAT(purchase_date, '%Y-%m') as ym"),
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('ym', 'status')
            ->orderBy('ym')
            ->get();

        // Prepare month labels and status counts
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

        // Yearly counts
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

        // Weekly counts (by day of week)
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

        // Prepare orderStatusCounts for JS
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

        // --- Sales data (for income) as before ---
        // Monthly sales (YYYY-MM)
        $monthlySales = Order::where('status', 'successful')
            ->select(DB::raw("DATE_FORMAT(purchase_date, '%Y-%m') as label"), DB::raw('SUM(order_total) as total'))
            ->groupBy('label')->orderBy('label')->get();

        // Yearly sales (YYYY)
        $yearlySales = Order::where('status', 'successful')
            ->select(DB::raw("DATE_FORMAT(purchase_date, '%Y') as label"), DB::raw('SUM(order_total) as total'))
            ->groupBy('label')->orderBy('label')->get();

        // Weekly sales (by day of week: Sunday-Saturday)
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

        return view('admin.statistics.index', compact(
            'orderCounts',
            'userCount',
            'productCount',
            'totalIncome',
            'incomeByStatus',
            'salesData',
            'orderStatusCounts'
        ));
    }
}