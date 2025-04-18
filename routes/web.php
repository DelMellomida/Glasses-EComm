<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

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
});
