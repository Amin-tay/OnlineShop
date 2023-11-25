<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('add product')) {
            return to_route('admin.products.index')->with('danger', 'You are not allowed to add Product!');
        }

        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('add product')) {
            return to_route('admin.products.index')->with('danger', 'You are not allowed to add Product!');
        }

//        $image = substr($request->file('image')->store('public/products'), 7);
//        dd($request);
        $product = Product::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category,
//            'image' => $image
        ]);

        $product->addMediaFromRequest('image')
//            ->withResponsiveImages()
            ->toMediaCollection('products');

        return to_route('admin.products.index')->with('success', 'Product Added!');
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
    public function edit(Product $product)
    {
        if (!auth()->user()->hasPermissionTo('edit product')) {
            return to_route('admin.products.index')->with('danger', 'You are not allowed to edit Product!');
        }

        $categories = Category::all();
        return view('admin.products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (!auth()->user()->hasPermissionTo('edit product')) {
            return to_route('admin.products.index')->with('danger', 'You are not allowed to edit Product!');
        }

//        $image = $product->image;

//        if ($request->hasFile('image')) {
//            Storage::delete('/storage/' . $product->image);
//            $image = substr($request->file('image')->store('public/products'), 7);
//        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category,
//            'image' => $image,
        ]);

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')
//            ->withResponsiveImages()
                ->toMediaCollection('products');
        }

        return to_route("admin.products.index")->with('success', 'Product Updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!auth()->user()->hasPermissionTo('delete product')) {
            return to_route('admin.products.index')->with('danger', 'You are not allowed to delete Product!');
        }

        $product->delete();
        return to_route('admin.products.index')->with('warning', 'Product Deleted!');
    }
}
