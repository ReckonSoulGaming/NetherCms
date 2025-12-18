<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\PaymentTransaction;

class PaymentHistoryAdminController extends Controller
{
    public function index()
    {
        $history = PaymentTransaction::orderBy('created_at', 'desc')->get();

        return view('manage.admin.payments.index', compact('history'));
    }
}
