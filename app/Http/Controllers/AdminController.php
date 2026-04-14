<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    protected $user;
    protected $order;

    public function __construct()
    {
        $this->user = new User();
        $this->order = new Order();
    }

    public function index()
    {
        $todayUsers = $this->user->whereDate('created_at', now()->toDateString())->count();
        $totalUsers = $this->user->count();

        $todayOrders = $this->order->whereDate('created_at', now()->toDateString())->count();
        $totalOrders = $this->order->count();

        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSubCategories = SubCategory::count();
        $totalBrands = Brand::count();

        $productStocks = Product::select('name', 'sku_code', 'stock', 'in_stock', 'image', 'price')
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        $salesData = $this->order->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(final_amount) as total')
        )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $salesLabels = [];
        $salesValues = [];
        foreach ($salesData as $data) {
            $salesLabels[] = Carbon::parse($data->date)->format('M d');
            $salesValues[] = $data->total ?? 0;
        }

        $ordersData = $this->order->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $ordersLabels = [];
        $ordersValues = [];
        foreach ($ordersData as $data) {
            $ordersLabels[] = Carbon::parse($data->date)->format('M d');
            $ordersValues[] = $data->count ?? 0;
        }

        $wallets = \App\Models\Wallet::latest()->take(20)->get();

        return view('welcome', compact(
            'todayUsers',
            'totalUsers',
            'todayOrders',
            'totalOrders',
            'totalProducts',
            'totalCategories',
            'totalSubCategories',
            'totalBrands',
            'productStocks',
            'salesLabels',
            'salesValues',
            'ordersLabels',
            'ordersValues',
            'wallets'
        ));
    }

    public function runCron()
    {
        Artisan::call('wallet:process-points');

        return redirect()->back()->with('success', 'Cron executed successfully');
    }
}
