<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Packages;
use App\PackageClaims;
use App\PaymentTransaction;
use App\ServerSettings;
use Auth;
use DB;

class RazorpayController extends Controller
{
    
    public function createOrder(Request $request)
    {
        $package = Packages::findOrFail($request->package_id);

       
        $gateway = DB::table('payment_method')
            ->where('method_provider', 'razorpay')
            ->where('enabled', 1)
            ->first();

      
        if (
            !$gateway ||
            empty($gateway->razorpay_key) ||
            empty($gateway->razorpay_secret)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay is not configured in admin panel.'
            ], 500);
        }

     
        $api = new Api(
            $gateway->razorpay_key,
            $gateway->razorpay_secret
        );

        $amount = $package->package_discount_price ?? $package->package_price;
        $amountPaise = $amount * 100;

        $order = $api->order->create([
            'receipt'  => 'order_' . time(),
            'amount'   => $amountPaise,
            'currency' => 'INR',
        ]);

       
        session([
            'purchase_package_id' => $package->package_id,
            'purchase_amount'     => $amount,
        ]);

        return response()->json([
            'success'  => true,
            'order_id' => $order['id'],
            'amount'   => $amountPaise,
            'key'      => $gateway->razorpay_key,
        ]);
    }

   
    public function verifyPayment(Request $request)
    {
        $gateway = DB::table('payment_method')
            ->where('method_provider', 'razorpay')
            ->where('enabled', 1)
            ->first();

        if (
            !$gateway ||
            empty($gateway->razorpay_key) ||
            empty($gateway->razorpay_secret)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay gateway disabled'
            ], 400);
        }

        try {
          
            $api = new Api(
                $gateway->razorpay_key,
                $gateway->razorpay_secret
            );

      
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->order_id,
                'razorpay_payment_id' => $request->payment_id,
                'razorpay_signature'  => $request->signature,
            ]);

            
            PaymentTransaction::create([
                'payment_provider'  => 'razorpay',
                'payment_payer_id'  => Auth::id(),
                'payment_payer'     => Auth::user()->name,
                'package_id'        => session('purchase_package_id'),
                'payment_amount'    => session('purchase_amount'),
                'payment_status'    => 'successful',
                'payment_method'    => 'online',
                'payment_id'        => $request->payment_id,
            ]);

          
            PackageClaims::create([
                'package_id' => session('purchase_package_id'),
                'owner_id'   => Auth::id(),
                'is_claimed' => 0,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {

          
            PaymentTransaction::create([
                'payment_provider'  => 'razorpay',
                'payment_payer_id'  => Auth::id(),
                'payment_payer'     => Auth::user()->name,
                'package_id'        => session('purchase_package_id'),
                'payment_amount'    => session('purchase_amount'),
                'payment_status'    => 'failed',
                'payment_method'    => 'online',
                'payment_id'        => $request->payment_id,
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
