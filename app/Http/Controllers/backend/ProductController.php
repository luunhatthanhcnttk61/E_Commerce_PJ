<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
        {
            $products = $this->productService->paginate();
            $config = $this->config();
            $template = 'backend.product.index';
            
            return view('backend.dashboard.layout', compact(
                'template',
                'config',
                'products'
            ));
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

    public function createProduct()
    {
        $config = $this->config();
        $template = 'backend.product.createProduct';
        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products',
            'price' => 'required|numeric|min:0',
            'inventory' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['status'] = 1;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }

        $result = $this->productService->createProduct($data);

        if($result) {
            return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công');
        }
        return redirect()->back()->with('error', 'Thêm sản phẩm thất bại')->withInput();
    }

    public function editProduct($id)
    {
        $product = $this->productService->findById($id);
        if(!$product) {
            return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm');
        }

        $config = $this->config();
        $template = 'backend.product.editProduct';
        return view('backend.dashboard.layout', compact('template', 'config', 'product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,'.$id,
            'price' => 'required|numeric|min:0',
            'inventory' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }

        $result = $this->productService->updateProduct($id, $data);

        if($result) {
            return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật sản phẩm thất bại')->withInput();
    }

    public function deleteProduct($id)
    {
        $result = $this->productService->deleteProduct($id);
        
        if($result) {
            return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công');
        }
        return redirect()->back()->with('error', 'Xóa sản phẩm thất bại');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        
        $result = $this->productService->updateProduct($id, ['status' => $status]);
        
        return response()->json(['success' => $result]);
    }
}