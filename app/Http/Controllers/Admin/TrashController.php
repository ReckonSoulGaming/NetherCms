<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Packages;
use Storage;

class TrashController extends AdminController
{
    public function index()
    {
        $deletedUsers    = User::onlyTrashed()->get();
        $deletedPackages = Packages::onlyTrashed()->get();

        return view('manage.admin.trash.trash', [
            'usertrashs'    => $deletedUsers,
            'packagetrashs' => $deletedPackages,
        ]);
    }

    public function rollbackUser($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();

        return redirect()->route('trash.index');
    }

    public function forcedeleteUser($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->forceDelete();

        return redirect()->route('trash.index');
    }

    public function rollbackPackage($id)
    {
        $package = Packages::onlyTrashed()->find($id);
        $package->restore();

        return redirect()->route('trash.index');
    }

    public function forcedeletePackage($id)
    {
        $package = Packages::onlyTrashed()->find($id);

       
        if (!empty($package->package_image_path)) {
            Storage::disk('local')->delete('public/packages/cover/' . $package->package_image_path);
        }

        $package->forceDelete();

        return redirect()->route('trash.index');
    }
}
