<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check admin role (1 = admin)
        if (Auth::user()->role_id == 1) {
            return $next($request);
        }

        session()->flash('noPermission');
        return redirect()->back();
    }
}
