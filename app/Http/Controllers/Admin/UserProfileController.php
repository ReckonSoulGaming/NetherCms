<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\User;
use Auth;
use Storage;

class UserProfileController extends AdminController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('manage.user.profile.index', [
            'user' => $this->getUserByName(Auth::user()->name),
        ]);
    }

    public function store(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->flash('successfullyUpdateData');

        return redirect()->route('profile.index');
    }

    public function changepassword()
    {
        return view('manage.user.profile.changepassword');
    }

    public function editprofile()
    {
        return view('manage.user.profile.editprofile', [
            'user' => $this->getUserByName(Auth::user()->name),
        ]);
    }

public function updateprofile(ProfileRequest $request)
{
    $user = Auth::user();

    // Update username
    $user->name = $request->name;

    // Update player type (new field)
    if ($request->has('player_type')) {
        $user->player_type = $request->player_type;
    }

    // Handle avatar upload
    if ($request->hasFile('avatar')) {

        // Delete old avatar if exists
        if ($user->profile_image_path) {
            Storage::delete('public/avatar/' . $user->profile_image_path);
        }

        // Upload new avatar
        $path = $request->file('avatar')->store('public/avatar');
        $filename = basename($path);
        $user->profile_image_path = $filename;
    }

    $user->save();

    session()->flash('successfullyUpdateData', 'Profile updated successfully');

    return redirect()->back();
}


}
