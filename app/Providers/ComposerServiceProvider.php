<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\Interfaces\CategoryServiceInterface;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(CategoryServiceInterface $categoryService)
    {
        // Share categories with specific views
        View::composer([
            'frontend.components.category-sidebar',
            'frontend.category.*',
            'frontend.product.*'
        ], function ($view) use ($categoryService) {
            $view->with('categories', $categoryService->getAllCategories());
        });
    }

    public function register()
    {
        //
    }
}