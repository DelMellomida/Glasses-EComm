<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::get('/admin/home', [AdminController::class, 'index'])->middleware('admin');

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
