<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Require authentication for all statistics pages.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display statistics dashboard.
     */
    public function index()
    {
        return view('statistics');
    }
}
