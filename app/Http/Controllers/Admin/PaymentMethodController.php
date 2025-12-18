<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
       
        $options = PaymentMethod::orderBy('method_id', 'asc')->get();

        return view('manage.admin.paymentmethod.index', [
            'options' => $options,
        ]);
    }

    public function create()
    {
        return view('manage.admin.paymentmethod.addpaymentmethod');
    }

    public function store(Request $request)
    {
        $request->validate([
            'method_provider' => 'required|string|max:50',
            'enabled'       => 'boolean',

            // Razorpay
            'razorpay_key'    => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',

            // Stripe
            'stripe_publishable_key' => 'nullable|string|max:255',
            'stripe_secret_key'      => 'nullable|string|max:255',

            // PayPal
            'paypal_client_id'  => 'nullable|string|max:255',
            'paypal_secret_key' => 'nullable|string|max:255',
            'paypal_mode'       => 'nullable|string|max:20',

            'callback_url'     => 'nullable|string|max:255',
            'webhook_secret'   => 'nullable|string|max:255',
        ]);

        PaymentMethod::create([
            'method_provider'  => $request->method_provider,

            'razorpay_key'    => $request->razorpay_key,
            'razorpay_secret' => $request->razorpay_secret,

            'stripe_publishable_key' => $request->stripe_publishable_key,
            'stripe_secret_key'      => $request->stripe_secret_key,

            'paypal_client_id'  => $request->paypal_client_id,
            'paypal_secret_key' => $request->paypal_secret_key,
            'paypal_mode'       => $request->paypal_mode,

            'callback_url'   => $request->callback_url,
            'webhook_secret' => $request->webhook_secret,
            'enabled'        => $request->enabled ? 1 : 0,
        ]);

        return redirect()->route('paymentmethod.index')->with('success', 'Gateway added successfully!');
    }

    public function edit($id)
    {
        $option = PaymentMethod::findOrFail($id);

        return view('manage.admin.paymentmethod.editpaymentmethod', [
            'option' => $option,
        ]);
    }

    public function update(Request $request, $id)
    {
        $option = PaymentMethod::findOrFail($id);

        $request->validate([
            'method_provider' => 'required|string|max:50',
            'enabled'       => 'boolean',
        ]);

        $option->update([
            'method_provider'  => $request->method_provider,

            'razorpay_key'    => $request->razorpay_key,
            'razorpay_secret' => $request->razorpay_secret,

            'stripe_publishable_key' => $request->stripe_publishable_key,
            'stripe_secret_key'      => $request->stripe_secret_key,

            'paypal_client_id'  => $request->paypal_client_id,
            'paypal_secret_key' => $request->paypal_secret_key,
            'paypal_mode'       => $request->paypal_mode,

            'callback_url'   => $request->callback_url,
            'webhook_secret' => $request->webhook_secret,
            'enabled'        => $request->enabled ? 1 : 0,
        ]);

        return redirect()->route('paymentmethod.index')->with('success', 'Gateway updated!');
    }

    public function destroy($id)
    {
        PaymentMethod::findOrFail($id)->delete();

        return redirect()->route('paymentmethod.index')->with('success', 'Gateway deleted.');
    }
}
