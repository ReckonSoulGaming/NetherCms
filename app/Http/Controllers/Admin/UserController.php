<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\UserEditorRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends AdminController
{
    public function index()
    {
        return view('manage.admin.usereditor.user', [
            'users'    => $this->getAllUsers(),
            'rolelist' => $this->getAllRoles(),
        ]);
    }

    public function create()
    {
        return view('manage.admin.usereditor.adduser', [
            'roles' => $this->getAllRoles(),
        ]);
    }

    public function store(UserEditorRequest $request)
    {
        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role_id'        => $request->role,
        ]);

        return redirect()->route('usereditor.index');
    }

    public function edit($id)
    {
        return view('manage.admin.usereditor.edituser', [
            'id'    => $id,
            'user'  => $this->getUser($id),
            'roles' => $this->getAllRoles(),
        ]);
    }

    public function update(UserEditorRequest $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'name'           => $request->name,
            'email'          => $request->email,
            'role_id'        => $request->role,
        ]);

        if ($request->password !== null) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('usereditor.index');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('usereditor.index');
    }

    public function doUpdate(Request $request)
    {
        $user = User::find($request->id);

        $user->update([
            'name'           => $request->name,
            'email'          => $request->email,
            'role_id'        => $request->role,
        ]);

        if ($request->password !== null) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('usereditor.index');
    }

    public function doDelete(Request $request)
    {
        User::find($request->id)->delete();

        return redirect()->route('usereditor.index');
    }
}
