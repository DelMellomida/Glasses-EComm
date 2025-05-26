<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Helpers\EventLogger;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->type === 'admin') {
            EventLogger::log('Admin Access', 'User accessed admin area', [
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);

            return $next($request);
        }

        EventLogger::log('Unauthorized Access', 'User attempted to access admin area without permission', [
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'url' => $request->fullUrl(),
        ]);

        return redirect('welcome')->with('error', 'Unauthorized access.');
    }
}

