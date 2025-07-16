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

        $categoryIds = [$category->id];
        if ($category->children && count($category->children)) {
            foreach ($category->children as $child) {
                $categoryIds[] = $child->id;
            }
        }

        $products = $this->productService->getProductsByCategories($categoryIds);

        return view('frontend.category.show', compact('category', 'products'));
    }

    public function showPrice($slug)
    {
        $category = $this->categoryService->findBySlug($slug);
        if(!$category) {
            abort(404);
        }

        $categoryIds = [$category->id];
        if ($category->children && count($category->children)) {
            foreach ($category->children as $child) {
                $categoryIds[] = $child->id;
            }
        }

        $priceFrom = request('price_from');
        $priceTo = request('price_to');

        $query = \App\Models\Product::whereIn('category_id', $categoryIds);

        if ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }
        if ($priceTo) {
            $query->where('price', '<=', $priceTo);
        }

        $products = $query->paginate(12); 

        return view('frontend.category.show', compact('category', 'products'));
    }

    public function findBySlug($slug)
    {
        return Category::where('slug', $slug)->where('status', 'active')->first();
    }
}