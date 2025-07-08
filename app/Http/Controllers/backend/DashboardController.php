<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index(){

        $totalOrders = \App\Models\Order::where('is_paid', true)->count();
        $totalRevenue = \App\Models\Order::where('is_paid', true)->sum('total_amount');
        $totalCustomers = \App\Models\Customer::count();

        $ordersByMonth = \App\Models\Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->where('is_paid', true)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $latestOrders = \App\Models\Order::orderBy('created_at', 'desc')->take(5)->get();
        $lowStockProducts = \App\Models\Product::where('inventory', '<', 5)->get();

        $config = $this->config();
        $template = 'backend.dashboard.home.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'ordersByMonth',
            'latestOrders',
            'lowStockProducts'
        ));
    }

    private function config()
    {
        return [
            'js' => [
                'backends/js/plugins/flot/jquery.flot.js',
                'backends/js/plugins/flot/jquery.flot.tooltip.min.js',
                'backends/js/plugins/flot/jquery.flot.spline.js',
                'backends/js/plugins/flot/jquery.flot.resize.js',
                'backends/js/plugins/flot/jquery.flot.pie.js',
                'backends/js/plugins/flot/jquery.flot.symbol.js',
                'backends/js/plugins/flot/jquery.flot.time.js',
                'backends/js/plugins/peity/jquery.peity.min.js',
                'backends/js/demo/peity-demo.js',
                'backends/js/inspinia.js',
                'backends/js/plugins/pace/pace.min.js',
                'backends/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
                'backends/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
                'backends/js/plugins/easypiechart/jquery.easypiechart.js',
                'backends/js/plugins/sparkline/jquery.sparkline.min.js',
                'backends/js/demo/sparkline-demo.js',
            ]
        ];
    }
}
