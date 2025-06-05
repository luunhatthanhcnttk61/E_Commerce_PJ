<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Services\Interfaces\CategoryServiceInterface as CategoryService;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
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

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        $config = $this->config();
        $template = 'backend.product.create';
        return view('backend.dashboard.layout', compact('template', 'config', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|unique:products',
        'category_id'=> 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'inventory' => 'required|integer|min:0',
    ]);

    $data = $request->all();
    $data['status'] = 1;

    // Upload main image
    if($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/products'), $filename);
        $data['image'] = 'uploads/products/' . $filename;
    }

    // Create product first
    $product = $this->productService->create($data);

    // Then upload multiple images if product was created successfully
    if($product && $request->hasFile('product_images')) {
        foreach($request->file('product_images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $filename);
            
            $product->images()->create([
                'image' => 'uploads/products/' . $filename
            ]);
        }
    }

    if($product) {
        return redirect()->route('admin.product.index')->with('success', 'Thêm sản phẩm thành công');
    }
    return redirect()->back()->with('error', 'Thêm sản phẩm thất bại')->withInput();
    }

    public function edit($id)
    {
        $product = $this->productService->findById($id);
        if(!$product) {
            return redirect()->route('admin.product.index')->with('error', 'Không tìm thấy sản phẩm');
        }

        $categories = $this->categoryService->getAllCategories();
        $config = $this->config();
        $template = 'backend.product.edit';
        return view('backend.dashboard.layout', compact('template', 'config', 'product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,'.$id,
            'category_id' => 'required|exists:categories,id',
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

        // Upload multiple images
        if($request->hasFile('product_images')) {
            foreach($request->file('product_images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $filename);
                
                $product->images()->create([
                    'image' => 'uploads/products/' . $filename
                ]);
            }
        }

        $result = $this->productService->update($id, $data);

        if($result) {
            return redirect()->route('admin.product.index')->with('success', 'Cập nhật sản phẩm thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật sản phẩm thất bại')->withInput();
    }

    public function delete($id)
    {
        $result = $this->productService->delete($id);
        
        if($result) {
            return redirect()->route('admin.product.index')->with('success', 'Xóa sản phẩm thành công');
        }
        return redirect()->back()->with('error', 'Xóa sản phẩm thất bại');
    }

    // public function updateStatus(Request $request)
    // {
    //     $id = $request->input('id');
    //     $status = $request->input('status');
        
    //     $result = $this->productService->update($id, ['status' => $status]);
        
    //     return response()->json(['success' => $result]);
    // }

    public function updateStatus(Request $request)
    {
        try {
            $id = $request->input('id');
            $status = $request->input('status');
            
            $result = $this->productService->update($id, ['status' => $status]);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    public function updateFeatured(Request $request)
    {
        try {
            $id = $request->input('id');
            $featured = $request->input('featured');
            
            $result = $this->productService->update($id, ['featured' => $featured]);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật nổi bật thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }
}