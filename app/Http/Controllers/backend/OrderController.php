<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use App\Models\Order;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->getOrders($request);
        $config = $this->config();
        $template = 'backend.order.index';
        
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'orders'
        ));
    }

    public function show($id)
    {
        $order = $this->orderService->findById($id);
        
        if(!$order) {
            return redirect()->route('order.index')->with('error', 'Không tìm thấy đơn hàng');
        }

        $config = $this->config();
        $template = 'backend.order.detail';
        
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'order'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        // $request->validate([
        //     'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        // ]);

        // $result = $this->orderService->updateStatus($id, $request->status);

        // if($result) {
        //     return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
        // }
        // return redirect()->back()->with('error', 'Cập nhật trạng thái thất bại');
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->order_status = $request->status;
            $order->status = $request->status;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        $result = $this->orderService->updateTracking($id, $request->tracking_number);

        if($result) {
            return redirect()->back()->with('success', 'Cập nhật mã vận đơn thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật mã vận đơn thất bại');
    }

    private function config()
    {
        return [
            'js' => [
                '/backends/js/plugins/switchery/switchery.js',
            ],
            'css' => [
                '/backends/css/plugins/switchery/switchery.css'
            ]
        ];
    }
}