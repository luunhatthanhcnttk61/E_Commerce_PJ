<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\OrderService;
use App\Repositories\CustomerRepository;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Services\CustomerService;
use App\Services\Interfaces\CustomerServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\CategoryService;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Repositories\ReviewRepository;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Services\ReviewService;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Repositories\ContactRepository;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Services\ContactService;
use App\Services\Interfaces\ContactServiceInterface;
use App\Repositories\SettingRepository;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Services\SettingService;
use App\Services\Interfaces\SettingServiceInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        //Product bindings
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        // Order bindings
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        //Customer bindings
        $this->app->bind(CustomerServiceInterface::class, CustomerService::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        //Category bindings
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);

        //Review bindings
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);

        //Contact bindings
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(ContactServiceInterface::class, ContactService::class);

        //Setting bindings
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(SettingServiceInterface::class, SettingService::class);

        //Cart bindings
        $this->app->bind(\App\Services\Interfaces\CartServiceInterface::class, \App\Services\CartService::class);
        $this->app->bind(\App\Repositories\Interfaces\CartRepositoryInterface::class, \App\Repositories\CartRepository::class);
    }

    public function boot()
    {
        //
    }
}