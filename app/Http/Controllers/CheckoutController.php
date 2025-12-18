<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Logs;
use App\Packages;
use App\PackageClaims;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        return redirect()->route('store');
    }

    public function buy($packageid)
    {
        $package = Packages::findOrFail($packageid);

        return view('checkout', [
            'packages' => $package,
        ]);
    }

  
    public function verifiedbuy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:packages,package_id'
        ]);

        $package = Packages::findOrFail($request->id);
        $user    = Auth::user();

        DB::beginTransaction();

        try {
         
            PackageClaims::create([
                'package_id' => $package->package_id,
                'owner_id'   => $user->id,
                'is_claimed' => 0,
            ]);

            $package->increment('package_sold');

      
            Logs::create([
                'user_id'        => $user->id,
                'name'           => $user->name,
                'type'           => 'PACKAGES:BUY',
                'message'        => "Purchased {$package->package_name} via payment gateway",
                'action_detail' => "TXN: " . ($request->txn_id ?? 'N/A'),
            ]);

            DB::commit();

            session()->flash('buyComplete', 'Payment successful! Your package has been delivered.');
            return redirect()->route('store');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Payment succeeded, but delivery failed. Contact support.');
            return redirect()->route('store');
        }
    }
}
