<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\OrderDetailController;

Route::get('/', function () {
    return view('guest.guest-home');
})->name('home');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Regular user dashboard
    // Route::middleware(['admin'])->group(function () {
    //     Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');
    // });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('/payment-method', 'payment.method')->name('payment.method');
    Route::get('/order-details', [OrderDetailController::class, 'getOrderDetailsByUserId'])->name('order-details.index');
});
// Route::get('/admin/home', [AdminController::class, 'index'])->middleware('admin');

Route::get('/products', function () {
    return view('product.home');
})->name('product.home');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'index']);
    
    Route::get('/admin/list-products', [ProductController::class, 'listAllProducts'])->name('admin.list-products');
    Route::post('/admin/add-product', [ProductController::class, 'store'])->name('admin.add-product');
    Route::put('/admin/update-product/{id}', [ProductController::class,'update'])->name('admin.update-product');
    Route::delete('/admin/delete-product/{id}', [ProductController::class,'destroy'])->name('admin.delete-product');
    
    Route::get('/admin/list-users', [AdminController::class, 'listUsers'])->name('admin.list-users');
    Route::get('/admin/list-admins', [AdminController::class, 'listAdmins'])->name('admin.list-admins');

    Route::post('/admin/change-user-role/{id}', [AdminController::class, 'changeUserRole'])->name('admin.change-user-role');
    Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

Route::get('/', [ProductController::class, 'showAllProductsInGuestView'])->name('guest.guest-home');