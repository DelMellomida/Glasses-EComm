<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Cart;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Only needed if you want to add a custom route for redirect
        Route::get('/redirect-after-login', function () {
            if (Auth::check() && Auth::user()->type === 'admin') {
                return redirect('/admin/home');
            }
            return redirect('/dashboard');
        });

        View::composer('*', function ($view) {
            $cart = Cart::with('items.product')
                ->where('user_id', auth()->id())
                ->orWhere('session_id', session()->getId())
                ->first();

            $view->with('cart', $cart);
        });
    }
}
