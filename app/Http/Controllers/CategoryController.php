<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function checkPermission($permission)
    {
//        dd($permission, !auth()->user()->hasPermissionTo($permission));
        if (!auth()->user()->hasPermissionTo($permission)) {
            return to_route('admin.categories.index')->with('danger', 'You are not allowed to ' . $permission . '!');
        }
    }

    public function index()
    {

        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $this->checkPermission('add category');
        if (!auth()->user()->hasPermissionTo('add category')) {
            return to_route('admin.categories.index')->with('danger', 'You are not allowed to add Category!');
        }

        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('add category')) {
            return to_route('admin.categories.index')->with('danger', 'You are not allowed to add Category!');
        }

        $this->checkPermission('add category');
        $image = substr($request->file('image')->store('public/categories'), 7);
        $category = Category::create([
            'name' => $request->name,
            'image' => $image,
        ]);
        $category->addMediaFromRequest('image')
//            ->withResponsiveImages()
            ->toMediaCollection('categories');

        return to_route('admin.categories.index')->with('success', 'Category Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if (!auth()->user()->hasPermissionTo('edit category')) {
            return to_route('admin.categories.index')->with('danger', 'You are not allowed to edit Category!');
        }

//        $this->checkPermission('edit category');
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if (!auth()->user()->hasPermissionTo('edit category')) {
            return to_route('admin.categories.index')->with('danger', 'You are not allowed to edit Category!');
        }

//        $this->checkPermission('edit category');

        $image = $category->image;
        if ($request->hasFile('image')) {
            Storage::delete('/storage/' . $category->image);
            $image = substr($request->file('image')->store('public/categories'), 7);
        }

        $category->update([
            'name' => $request->name,
            'image' => $image,
        ]);


        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')
//            ->withResponsiveImages()
                ->toMediaCollection('categories');
        }
        return to_route('admin.categories.index')->with('success', 'Category Updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!auth()->user()->hasPermissionTo('delete category')) {
            return to_route('admin.categories.index')->with('danger', 'You are not allowed to delete Category!');
        }
//        $this->checkPermission('delete category');
        $category->delete();
        return to_route('admin.categories.index')->with('warning', 'Category Deleted!');

    }
}
