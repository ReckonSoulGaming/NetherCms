<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PackageCategory;
use App\User;
use App\Alert;
use Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('adminonly');
    }

    public function getAllCategory()
    {
        return PackageCategory::all();
    }

    public function saveAndGetFile($path, $file)
    {
        $saved = Storage::disk('local')->put($path, $file);
        return basename($saved);
    }

    public function getAllUsers()
    {
        return User::all();
    }
}
