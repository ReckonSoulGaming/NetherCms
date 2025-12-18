<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends AdminController
{
    public function index()
    {
        return view('manage.admin.dashboard.dashboard', [
            'users'               => $this->getAllUsers(),
            'packages'            => $this->getAllPackage(),
            'alerts'             => $this->getAllAlerts(),
            'all_sold_packages'   => $this->getAllPackage()->sum('package_sold'),
            'all_payment_amount'  => $this->getAllPaymentTransactions()->sum('payment_amount'),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
