<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ProductController;
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

Route::middleware(['auth', 'admin'])->group(function () {
    // Product routes
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'createProduct'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'storeProduct'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
    Route::post('/product/update-status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');
});
