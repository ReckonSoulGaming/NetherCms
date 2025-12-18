<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyServer
{
    public function handle(Request $request, Closure $next)
    {
        $serverId = $request->header('X-SERVER-ID');
        $apiKey   = $request->header('X-API-KEY');

        if (!$serverId || !$apiKey) {
            return response()->json(['error' => 'missing_headers']);
        }

        $server = DB::table('server_settings')
                    ->where('server_id', $serverId)
                    ->where('websender_password', $apiKey)
                    ->first();

        if (!$server) {
            return response()->json(['error' => 'invalid_server']);
        }

        // store it safely
        $request->attributes->set('server', $server);

        return $next($request);
    }
}
