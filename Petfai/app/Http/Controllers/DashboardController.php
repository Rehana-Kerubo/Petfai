<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\View\View;
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

        return view('dashboard', [
            'todayRevenue' => $todayRevenue,
            'todayProfit' => $todayProfit,
            'weekRevenue' => $weekRevenue,
            'weekProfit' => $weekProfit,
            'topProducts' => $topProducts,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}