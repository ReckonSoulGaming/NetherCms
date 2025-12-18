<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\PackageCategory;
use App\Packages;
use Illuminate\Support\Facades\Storage;

class CategoryController extends AdminController
{
    public function index()
    {
        return view('manage.admin.category', [
            'categorys' => $this->getAllCategory(),
        ]);
    }

    public function store(Request $request)
    {
        $category = new PackageCategory;

        $category->category_name     = $request->category_name;
        $category->description       = $request->description;
        $category->badge_text        = $request->badge_text;
        $category->badge_color       = $request->badge_color ?? 'is-danger';
        $category->ribbon_text       = $request->ribbon_text;
        $category->is_featured       = $request->has('is_featured') ? 1 : 0;
        $category->is_visible        = $request->has('is_visible') ? 1 : 0;
        $category->sort_order        = $request->sort_order ?? 0;
        $category->background_color  = $request->background_color;
        $category->custom_css        = $request->custom_css;

        if ($request->hasFile('category_image')) {
            $name = time() . '_' . $request->file('category_image')->getClientOriginalName();
            $request->file('category_image')->storeAs('public/packages/category', $name);
            $category->category_image = $name;
        }

        $category->save();

        return redirect()->back()->with('manageCategoryAdded', 'Category added successfully!');
    }

    public function edit(PackageCategory $category)
    {
        return view('manage.admin.partials.edit-category-form', compact('category'));
    }

    public function update(Request $request, PackageCategory $category)
    {
        $category->category_name     = $request->category_name;
        $category->description       = $request->description;
        $category->badge_text        = $request->badge_text;
        $category->badge_color       = $request->badge_color ?? 'is-danger';
        $category->ribbon_text       = $request->ribbon_text;
        $category->is_featured       = $request->has('is_featured') ? 1 : 0;
        $category->is_visible        = $request->has('is_visible') ? 1 : 1; // kept exactly as your logic
        $category->sort_order        = $request->sort_order ?? 0;
        $category->background_color  = $request->background_color;
        $category->custom_css        = $request->custom_css;

        if ($request->hasFile('category_image')) {

            // Delete old image
            if ($category->category_image) {
                Storage::delete('public/packages/category/' . $category->category_image);
            }

            $name = time() . '_' . $request->file('category_image')->getClientOriginalName();
            $request->file('category_image')->storeAs('public/packages/category', $name);
            $category->category_image = $name;
        }

        $category->save();

        return redirect()->back()->with('manageCategoryUpdated', 'Category updated successfully!');
    }

    public function destroy(PackageCategory $category)
    {
        if ($category->category_id == 1) {
            return redirect()->back()->with('somethingError', 'Cannot delete default category.');
        }

        // Move all packages to category 1
        Packages::where('category_id', $category->category_id)
            ->update(['category_id' => 1]);

        // Delete category image
        if ($category->category_image) {
            Storage::delete('public/packages/category/' . $category->category_image);
        }

        $category->delete();

        return redirect()->back()->with('manageCategoryRemoved', 'Category deleted successfully!');
    }

    // Unused
    public function create() {}
    public function show($id) {}
}
