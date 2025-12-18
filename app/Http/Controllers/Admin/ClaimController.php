<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PackageClaims;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Fetch NOT claimed packages
        $claims = PackageClaims::with(['package', 'user'])
                    ->where('owner_id', $userId)
                    ->where('is_claimed', 0)
                    ->get();

        // Fetch ALREADY claimed packages
        $claimed = PackageClaims::with(['package', 'user'])
                    ->where('owner_id', $userId)
                    ->where('is_claimed', 1)
                    ->get();

        return view('manage.user.claim.index', compact('claims', 'claimed'));
    }

    public function store(Request $request)
    {
        $claim = PackageClaims::find($request->id);

        if (!$claim) {
            return back()->with('error', 'Package not found.');
        }

        // Mark as claimed
        $claim->is_claimed = 1;
        $claim->save();


        return back()->with('success', 'Package claimed successfully!');
    }
}
