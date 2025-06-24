<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\Interfaces\CustomerServiceInterface as CustomerService;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        $customers = $query->leftJoin('orders', 'customers.id', '=', 'orders.user_id')
            ->select(
                'customers.*',
                \DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
                \DB::raw('COALESCE(SUM(orders.total_amount), 0) as total_spent')
            )
            ->groupBy(
                'customers.id',
                'customers.name',
                'customers.email',
                'customers.phone',
                'customers.address',
                'customers.created_at',
                'customers.updated_at'
            )
            ->paginate(10);

        $config = $this->config();
        $template = 'backend.customer.index';
        
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'customers'
        ));
    }

    public function show($id)
    {
        $customer = $this->customerService->findById($id);
        if(!$customer) {
            return redirect()->route('admin.customer.index')->with('error', 'Không tìm thấy khách hàng');
        }

        $config = $this->config();
        $template = 'backend.customer.show';
        
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'customer'
        ));
    }

    public function updateStatus(Request $request)
    {
        $result = $this->customerService->updateStatus(
            $request->customer_id,
            $request->status
        );

        return response()->json(['success' => $result]);
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