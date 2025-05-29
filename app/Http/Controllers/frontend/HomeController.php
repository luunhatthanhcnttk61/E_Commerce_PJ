<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;

class HomeController extends Controller
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
        $featured_products = $this->productService->getFeaturedProducts();
        $new_products = $this->productService->getNewProducts();
        $categories = $this->categoryService->getAllCategories();

        return view('frontend.home.index', compact(
            'featured_products',
            'new_products',
            'categories'
        ));
    }
}