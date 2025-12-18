<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        return view('manage.admin.store', [
            'categorys' => $this->getAllCategory(),
            'packages'  => Packages::orderByDesc('package_id')->get(),
        ]);
    }

    public function create()
    {
        return view('manage.admin.addpackage', [
            'categorys' => $this->getAllCategory(),
        ]);
    }

    /**
     * Helper: Save file and return filename
     */
    private function saveAndGetFile($path, $file)
    {
        if (!$file) {
            return null;
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $filename, 'public');

        return $filename;
    }

   
public function store(PackageRequest $request)
{
    try {

        $package = new Packages;

        $package->package_name           = $request->package_name;
        $package->package_desc           = $request->package_desc;
        $package->package_price          = $request->package_price;
        $package->package_discount_price = $request->filled('package_discount_price') 
                                            ? $request->package_discount_price 
                                            : null;

        $package->category_id     = $request->category;
        $package->package_command = $request->package_command;
        $package->package_sold    = 0;

        $package->package_features = $request->package_features;
        $package->badge_text       = $request->filled('badge_text') ? $request->badge_text : null;
        $package->badge_color      = $request->badge_color ?? 'is-danger';
        $package->ribbon_text      = $request->filled('ribbon_text') ? $request->ribbon_text : null;
        $package->is_featured      = $request->has('is_featured');
        $package->stock_limit      = $request->filled('stock_limit') ? $request->stock_limit : null;

      
        if ($request->hasFile('cover')) {
            $package->package_image_path = $this->saveAndGetFile(
                'packages/cover',
                $request->file('cover')
            );
        }

        $package->save();

        $this->addLog(auth()->id(), 'admin:addpackage', "Package ADDED: {$package->package_name}");

        session()->flash('managePackageAdded', 'Package created successfully!');
        return redirect()->route('package.index');

    } catch (\Exception $e) {

        return back()->withErrors([
            'store_error' => 'Something went wrong while saving the package.'
        ])->withInput();
    }
}



    public function edit($id)
    {
        return view('manage.admin.editpackage', [
            'package'   => Packages::findOrFail($id),
            'categorys' => $this->getAllCategory(),
        ]);
    }

 
    public function update(PackageRequest $request, $id)
    {
        $package  = Packages::findOrFail($id);
        $oldImage = $package->package_image_path;

        $package->update([
            'package_name'           => $request->package_name,
            'package_desc'           => $request->package_desc,
            'package_price'          => $request->package_price,
            'package_discount_price' => $request->filled('package_discount_price') ? $request->package_discount_price : null,
            'category_id'            => $request->category,
            'package_command'        => $request->package_command,

       
            'package_features'       => $request->package_features,
            'badge_text'             => $request->filled('badge_text') ? $request->badge_text : null,
            'badge_color'            => $request->badge_color ?? 'is-danger',
            'ribbon_text'            => $request->filled('ribbon_text') ? $request->ribbon_text : null,
            'is_featured'            => $request->has('is_featured'),
            'stock_limit'            => $request->filled('stock_limit') ? $request->stock_limit : null,
        ]);

        if ($request->hasFile('cover')) {
            if ($oldImage) {
                Storage::disk('public')->delete('packages/cover/' . $oldImage);
            }

            $package->package_image_path = $this->saveAndGetFile('packages/cover', $request->file('cover'));
            $package->save();
        }

        session()->flash('managePackageEdited', 'Package updated successfully!');
        return redirect()->route('package.index');
    }

    
public function doUpdate(Request $request)
{
    $request->validate([
        'id'              => 'required|exists:packages,package_id',

        'package_name'    => 'required|string|max:50',
        'category'        => 'required|exists:packages_category,category_id',

        'package_features'    => 'nullable|string',
        'package_command'     => 'nullable|string',
        'package_price'       => 'nullable|numeric',
        'package_discount_price' => 'nullable|numeric',
        'badge_text'          => 'nullable|string|max:20',
        'badge_color'         => 'nullable|in:is-danger,is-success,is-warning,is-info,is-primary',
        'ribbon_text'         => 'nullable|string|max:15',
        'stock_limit'         => 'nullable|integer|min:1',
    ]);

    $package  = Packages::findOrFail($request->id);
    $oldImage = $package->package_image_path;

    $package->update([
        'package_name'           => $request->package_name,
        'package_desc'           => $request->package_desc ?? $package->package_desc,
        'package_price'          => $request->filled('package_price') ? $request->package_price : $package->package_price,
        'package_discount_price' => $request->filled('package_discount_price') ? $request->package_discount_price : $package->package_discount_price,
        'category_id'            => $request->category,
        'package_command'        => $request->filled('package_command') ? $request->package_command : $package->package_command,
        'package_features'       => $request->filled('package_features') ? $request->package_features : $package->package_features,
        'badge_text'             => $request->filled('badge_text') ? $request->badge_text : $package->badge_text,
        'badge_color'            => $request->badge_color ?? $package->badge_color,
        'ribbon_text'            => $request->filled('ribbon_text') ? $request->ribbon_text : $package->ribbon_text,
        'is_featured'            => $request->has('is_featured'),
        'stock_limit'            => $request->filled('stock_limit') ? $request->stock_limit : $package->stock_limit,
    ]);

   
    if ($request->hasFile('cover')) {

        if ($oldImage) {
            Storage::disk('public')->delete('packages/cover/' . $oldImage);
        }

        $package->package_image_path = $this->saveAndGetFile(
            'packages/cover',
            $request->file('cover')
        );

        $package->save();
    }

    session()->flash('managePackageEdited', 'Package updated successfully!');
    return redirect()->route('package.index');
}


    public function destroy($id)
    {
        $package = Packages::findOrFail($id);

        if ($package->package_image_path) {
            Storage::disk('public')->delete('packages/cover/' . $package->package_image_path);
        }

        $package->delete();

        session()->flash('managePackageRemoved', 'Package deleted successfully.');
        return redirect()->route('package.index');
    }

    public function doDelete(Request $request)
    {
        $package = Packages::findOrFail($request->id);

        if ($package->package_image_path) {
            Storage::disk('public')->delete('packages/cover/' . $package->package_image_path);
        }

        $package->delete();

        return redirect()->route('package.index');
    }
}
