<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;

class FrontendCategoryController extends Controller
{
    protected $categoryService;
    protected $productService;

    public function __construct(
        CategoryServiceInterface $categoryService,
        ProductServiceInterface $productService
    ) {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function show($slug)
    {
        $category = $this->categoryService->findBySlug($slug);
        if(!$category) {
            abort(404);
        }

        $products = $this->productService->getProductsByCategory($category->id);
        //$categories = $this->categoryService->getAllCategories();
        
        return view('frontend.category.show', compact('category', 'products'));
    }

    public function findBySlug($slug)
    {
        return Category::where('slug', $slug)->where('status', 'active')->first();
    }
}