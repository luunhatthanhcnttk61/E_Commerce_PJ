<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
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
        $customers = $this->customerService->getCustomers($request);
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
            return redirect()->route('customer.index')->with('error', 'Không tìm thấy khách hàng');
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