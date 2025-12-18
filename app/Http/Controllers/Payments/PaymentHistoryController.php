<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\PaymentTransaction;
use Auth;

class PaymentHistoryController extends Controller
{
    public function index()
    {
      
        $history = PaymentTransaction::where('payment_payer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('manage.payment.history', compact('history'));
    }
}
