<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\{
    AuthController as AdminAuth,
    DashboardController,
    UserController,
    ProductController as BackendProductController,
    OrderController,
    CustomerController,
    CategoryController,
    ReviewController,
    ContactController,
    SettingController
};
use App\Http\Controllers\Frontend\{
    AuthController as ClientAuth,
    HomeController,
    CartController,
    CheckoutController,
    AccountController,
    FrontendProductController,
    FrontendCategoryController,
    FrontendReviewController,
    FrontendContactController
};

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Auth Routes (No Auth Required)
    Route::middleware('guest')->group(function () {
        Route::get('/', [AdminAuth::class, 'showLoginForm'])->name('auth.login');
        Route::post('/login', [AdminAuth::class, 'login'])->name('auth.login.post');
        Route::get('/register', [AdminAuth::class, 'showRegistrationForm'])->name('auth.register');
        Route::post('/register', [AdminAuth::class, 'register'])->name('auth.register.post');
    });
    
    // Admin Protected Routes
    Route::middleware('auth')->group(function () {
        Route::get('/logout', [AdminAuth::class, 'logout'])->name('auth.logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Admin Only Routes
        Route::middleware(['admin'])->group(function () {
            // User Management
            Route::prefix('user')->name('user.')->group(function() {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('/{id}', [UserController::class, 'update'])->name('update');
                Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
                Route::post('/update-status', [UserController::class, 'updateStatus'])->name('updateStatus');
            });
        });

        // Products Management
        Route::prefix('product')->name('product.')->group(function() {
            Route::get('/', [BackendProductController::class, 'index'])->name('index');
            Route::get('/create', [BackendProductController::class, 'create'])->name('create');
            Route::post('/store', [BackendProductController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [BackendProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BackendProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [BackendProductController::class, 'delete'])->name('delete');
            Route::post('/update-status', [BackendProductController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/update-featured', [BackendProductController::class, 'updateFeatured'])->name('updateFeatured');
        });

        // Categories Management
        Route::prefix('category')->name('category.')->group(function() {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoryController::class, 'delete'])->name('delete');
            Route::post('/update-status', [CategoryController::class, 'updateStatus'])->name('updateStatus');
        });

        // Orders Management
        Route::prefix('order')->name('order.')->group(function() {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
            Route::put('/{id}/tracking', [OrderController::class, 'updateTracking'])->name('updateTracking');
        });

        // Customers Management
        Route::prefix('customer')->name('customer.')->group(function() {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
            Route::post('/update-status', [CustomerController::class, 'updateStatus'])->name('updateStatus');
        });

        // Reviews Management
        Route::prefix('review')->name('review.')->group(function() {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
            Route::post('/update-status', [ReviewController::class, 'updateStatus'])->name('updateStatus');
        });

        // Contact Management
        Route::prefix('contact')->name('contact.')->group(function() {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::get('/{id}', [ContactController::class, 'show'])->name('show');
            Route::post('/update-status/{id}', [ContactController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{id}/reply', [ContactController::class, 'reply'])->name('reply');
        });

        // Settings
        Route::prefix('setting')->name('setting.')->group(function() {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/update', [SettingController::class, 'update'])->name('update');
        });
    });
});

// Client/Frontend Routes
Route::name('client.')->group(function () {
    // Public Routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Auth Routes
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::get('/login', [ClientAuth::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ClientAuth::class, 'login'])->name('login.post');
        Route::get('/register', [ClientAuth::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [ClientAuth::class, 'register'])->name('register.post');
        Route::post('/logout', [ClientAuth::class, 'logout'])->name('logout');
    });

    // Product Routes (Public)
    Route::prefix('product')->name('product.')->group(function() {
        Route::get('/', [FrontendProductController::class, 'index'])->name('index');
        //Route::get('/category/{category_id}', [FrontendProductController::class, 'byCategory'])->name('byCategory');
        Route::get('/{id}', [FrontendProductController::class, 'show'])->name('show');
    });

    // Cart Routes (Public)
    Route::prefix('cart')->name('cart.')->group(function() {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    });

    // Category Routes
    Route::prefix('category')->name('category.')->group(function() {
        Route::get('/{slug}', [FrontendCategoryController::class, 'show'])->name('show');
    });

    // Review Routes
    Route::prefix('review')->name('review.')->middleware('auth')->group(function() {
        Route::post('/store', [FrontendReviewController::class, 'store'])->name('store');
    });

    // Contact Routes
    Route::prefix('contact')->name('contact.')->group(function() {
        Route::get('/', [FrontendContactController::class, 'index'])->name('index');
        Route::post('/store', [FrontendContactController::class, 'store'])->name('store');
    });

    // Protected Client Routes
    Route::middleware('auth')->group(function() {
        // Checkout Routes
        Route::prefix('checkout')->name('checkout.')->group(function() {
            Route::get('/', [CheckoutController::class, 'index'])->name('index');
            Route::post('/process', [CheckoutController::class, 'process'])->name('process');
            Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
            Route::get('/failed/{order}', [CheckoutController::class, 'failed'])->name('failed');
            Route::get('/callback', [CheckoutController::class, 'callback'])->name('callback');
        });

        // Account Routes
        Route::prefix('account')->name('account.')->group(function() {
            Route::get('/', [AccountController::class, 'index'])->name('index');
            Route::put('/update', [AccountController::class, 'update'])->name('update');
            Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
            Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
            Route::get('/password', [AccountController::class, 'password'])->name('password');
            Route::put('/password/update', [AccountController::class, 'updatePassword'])->name('password.update');
        });

        
    });
});

