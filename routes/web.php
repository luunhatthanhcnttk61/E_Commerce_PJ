<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ReviewController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Middleware\AuthenticateMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('auth.register.post');

Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(AuthenticateMiddleware::class);

/* User */ 
// Route::get('/user/index', [UserController::class, 'index'])->name('user.index')->middleware(AuthenticateMiddleware::class);

// Route::get('/user/create', [UserController::class, 'createUser'])->name('user.createUser')->middleware(AuthenticateMiddleware::class);
// Route::post('/user/store', [UserController::class, 'storeUser'])->name('user.storeUser')->middleware(AuthenticateMiddleware::class);
// Route::middleware(['auth'])->group(function(){
//     Route::get('/user/edit/{id}', [UserController::class, 'editUser'])->name('user.editUser');
//     Route::post('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.updateUser');
//     Route::delete('/user/delete/{id}', [UserController::class, 'deleteUser'])->name('user.deleteUser');
// });

// Route::post('/user/update-status', [UserController::class, 'updateStatus'])
//     ->name('user.updateStatus')
//     ->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/user/create', [UserController::class, 'createUser'])->name('user.createUser');
    Route::post('/user/store', [UserController::class, 'storeUser'])->name('user.storeUser');
    Route::get('/user/edit/{id}', [UserController::class, 'editUser'])->name('user.editUser');
    Route::put('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.updateUser');
    Route::delete('/user/delete/{id}', [UserController::class, 'deleteUser'])->name('user.deleteUser');
    Route::post('/user/update-status', [UserController::class, 'updateStatus'])->name('user.updateStatus');
});

// Route không yêu cầu quyền admin
Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Product routes
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'createProduct'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'storeProduct'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
    Route::post('/product/update-status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');

    // Order routes
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::put('/order/{id}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::put('/order/{id}/tracking', [OrderController::class, 'updateTracking'])->name('order.updateTracking');

    // Customer routes
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::post('/customer/update-status', [CustomerController::class, 'updateStatus'])->name('customer.updateStatus');

    // Category routes 
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/category/update-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');

    //Review routes
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::post('/review/update-status', [ReviewController::class, 'updateStatus'])->name('review.updateStatus');

    // Contact routes 
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact/update-status', [ContactController::class, 'updateStatus'])->name('contact.updateStatus');
    Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');

    // Setting routes
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index'); 
    Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
});
// Client Routes
Route::name('client.')->group(function () {
     // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failed/{order}', [CheckoutController::class, 'failed'])->name('checkout.failed');
    Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');

    // Authentication Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Account Routes
    Route::middleware('auth')->group(function() {
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
        Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
        Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
        Route::get('/account/password', [AccountController::class, 'password'])->name('account.password');
        Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    });
});
