<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;

class FrontendProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(
        ProductServiceInterface $productService,
        CategoryServiceInterface $categoryService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        $categories = $this->categoryService->getAllCategories();
        
        return view('frontend.product.index', compact('products', 'categories'));
    }

    public function search(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Product::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $products = $query->paginate(12);
        $categories = $this->categoryService->getAllCategories();

        return view('frontend.product.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = $this->productService->findById($id);
        if (!$product) {
            abort(404);
        }

        $approvedReviews = $product->reviews()
            ->where('status', 'approved')
            ->with('customer')
            ->latest()
            ->get();

        $product->load(['category', 'images']);

        $relatedProducts = $this->productService->getRelatedProducts($id);
        
        return view('frontend.product.detail', compact(
            'product',
            'approvedReviews',
            'relatedProducts'
        ));
    }

    public function byCategory($category_id)
    {
        $category = $this->categoryService->findById($category_id);
        if(!$category) {
            abort(404);
        }

        $products = $this->productService->getProductsByCategory($category_id);
        $categories = $this->categoryService->getAllCategories();

        return view('frontend.product.by_category', compact('products', 'category', 'categories'));
    }
}