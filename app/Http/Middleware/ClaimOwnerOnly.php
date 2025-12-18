<?php

namespace App\Http\Middleware;

use Closure;
use App\PackageClaims;
use Auth;

class ClaimOwnerOnly
{
    public function handle($request, Closure $next)
    {

        $claim = PackageClaims::findOrFail($request->id);

        if(Auth::user()->id == $claim->owner_id) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
