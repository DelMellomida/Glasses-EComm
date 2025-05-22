<?php

use App\Http\Controllers\Admin\StatisticsController as AdminStatisticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AppointmentController;

Route::get('/redirect-after-login', function () {
    if (Auth::check() && Auth::user()->type === 'admin') {
        return redirect('/admin/home');
    }
        return redirect('/dashboard');
});

Route::get('/products', function () {
    return view('product.home');
})->name('product.home');

Route::get('/', [ProductController::class, 'showAllProductsInGuestView'])->name('guest.guest-home');

Route::get('/', [ProductController::class, 'showAllProductsInProductsView'])->name('product.home');

Route::get('/about-us', function () {
    return view('aboutus.about-home');
})->name('about-us');

Route::get('/contacts', function () {
    return view('contacts.contacts-home');
})->name('contacts');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{id}/edit', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Route::resource('appointments', AppointmentController::class);
    Route::get('/appointments/json', [AppointmentController::class, 'appointments'])->name('appointments.json');

    Route::view('/payment-method', 'payment.method')->name('payment.method');
});

Route::get('/order-details', [OrderDetailController::class, 'getOrderDetailsByUserId'])->name('order-details.index');



Route::middleware(['admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'index'])->name("admin.dashboard");

    Route::get('admin/statistics', [StatisticsController::class, 'index'])->name('admin.statistics');
    
    Route::get('/admin/list-products', [ProductController::class, 'listAllProducts'])->name('admin.list-products');
    Route::post('/admin/add-product', [ProductController::class, 'store'])->name('admin.add-product');
    Route::put('/admin/update-product/{id}', [ProductController::class,'update'])->name('admin.update-product');
    Route::delete('/admin/delete-product/{id}', [ProductController::class,'destroy'])->name('admin.delete-product');
    
    Route::get('/admin/list-users', [AdminController::class, 'userIndex'])->name('user.index');
    Route::get('/admin/list-admins', [AdminController::class, 'adminIndex'])->name('admin.index');
    Route::get('/admin/list-users/data', [AdminController::class, 'listUsers'])->name('admin.list-users');
    Route::get('/admin/list-admins/data', [AdminController::class, 'listAdmins'])->name('admin.list-admins');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.user.edit');
    Route::post('/admin/users/{id}/edit', [AdminController::class, 'update'])->name('admin.user.update');
    Route::get('/admin/add-user', [AdminController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.user.store');

    Route::get('/admin/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/admin/add-category', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/add-new-category', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::get('/admin/list-categories/data', [CategoryController::class, 'listCategories'])->name('admin.list-categories');
    Route::put('/admin/category/{id}/edit', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    Route::get('/admin/all-transactions', [OrderController::class, 'index'])->name('all-transaction.index');
    Route::get('/admin/successful-transactions', [OrderController::class, 'successfulIndex'])->name('successful-transaction.index');
    Route::get('/admin/failed-transactions', [OrderController::class, 'failedindex'])->name('failed-transaction.index');
    Route::get('/admin/add-transaction', [OrderController::class, 'create'])->name('admin.transaction.create');
    Route::post('/admin/add-new-transaction', [OrderController::class, 'store'])->name('admin.transaction.store');
    Route::get('/admin/transaction/{id}/edit', [OrderController::class, 'edit'])->name('admin.transaction.edit');
    Route::get('/admin/all-transactions/data', [OrderController::class, 'listAllTransactions'])->name('admin.all-transactions');
    Route::get('/admin/successful-transactions/data', [OrderController::class, 'listSuccessfulTransactions'])->name('admin.successful-transactions');
    Route::get('/admin/failed-transactions/data', [OrderController::class, 'listFailedTransactions'])->name('admin.failed-transactions');
    Route::put('/admin/transaction/{id}/edit', [OrderController::class, 'update'])->name('admin.transaction.update');
    Route::delete('/admin/transaction/{id}/delete', [OrderController::class, 'destroy'])->name('admin.transaction.destroy');


    Route::delete('/user-detail/{id}', [AdminController::class, 'destroy'])->name('admin.user.destroy');


    Route::post('/admin/change-user-role/{id}', [AdminController::class, 'changeUserRole'])->name('admin.change-user-role');
    Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});
// Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');