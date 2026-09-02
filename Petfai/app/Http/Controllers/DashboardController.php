<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();

        $todaySales = SaleItem::whereHas('sale', fn($q) => $q->where('created_at', '>=', $today));
        $weekSales = SaleItem::whereHas('sale', fn($q) => $q->where('created_at', '>=', $weekStart));

        $todayRevenue = (clone $todaySales)->sum(DB::raw('quantity * price_at_sale'));
        $todayProfit = (clone $todaySales)->sum(DB::raw('quantity * (price_at_sale - cost_at_sale)'));

        $weekRevenue = (clone $weekSales)->sum(\DB::raw('quantity * price_at_sale'));
        $weekProfit = (clone $weekSales)->sum(\DB::raw('quantity * (price_at_sale - cost_at_sale)'));

        $topProducts = SaleItem::selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->take(5)
            ->get();

        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->get();

        $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
    $date = now()->subDays($daysAgo);
    $dayTotal = SaleItem::whereHas('sale', fn($q) =>
            $q->whereDate('created_at', $date->toDateString())
        )
        ->sum(DB::raw('quantity * price_at_sale'));

    return [
        'label' => $date->format('D'),
        'total' => (float) $dayTotal,
    ];
});

        return view('dashboard', [
            'todayRevenue' => $todayRevenue,
            'todayProfit' => $todayProfit,
            'weekRevenue' => $weekRevenue,
            'weekProfit' => $weekProfit,
            'topProducts' => $topProducts,
            'lowStockProducts' => $lowStockProducts,
            'last7Days' => $last7Days,
        ]);
    }

    public function salesLog(Request $request): View
{
    $date = $request->input('date', now()->toDateString());

    $sales = Sale::with('cashier', 'items.product')
        ->whereDate('created_at', $date)
        ->orderByDesc('created_at')
        ->get();

    $cashTotal = $sales->where('payment_method', 'cash')->sum('total');
    $mpesaTotal = $sales->where('payment_method', 'mpesa')->sum('total');

    return view('dashboard.sales-log', [
        'sales' => $sales,
        'date' => $date,
        'cashTotal' => $cashTotal,
        'mpesaTotal' => $mpesaTotal,
    ]);
}
}