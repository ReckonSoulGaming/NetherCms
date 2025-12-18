<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackageCategory;

class StoreController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth')->except('index');
    }

    /**
     * Display the store page (guest or logged-in user)
     */
  public function index()
{
    $categories = PackageCategory::orderBy('category_id', 'desc')->get();
    $packages   = $this->getAllPackage();  

    return view('store', [
        'categorys'  => $categories,
        'server'     => auth()->check() ? $this->getServerInfo() : (object)[],
        'packages'   => $packages, 
        'lastest'    => auth()->check() ? $this->getLastestAddPackage() : collect([]),
        'bestseller' => auth()->check() ? $this->getBestSellerPackage() : collect([]),
        'settings'   => $this->getSettings(),
        'alerts'    => auth()->check() ? $this->getOnlyStoreAlerts() : collect([]),
        'discount'   => auth()->check() ? $this->getDiscountPackage() : collect([]),
    ]);
}

}
