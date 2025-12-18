<?php

namespace App\Http\Middleware;

use Closure;
use App\ApiKey;

class ApiAuth
{
    public function handle($request, Closure $next)
    {
        $key = $request->header('X-API-KEY');

        if (!$key || !ApiKey::where('key', $key)->exists()) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        return $next($request);
    }
}

