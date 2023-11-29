<?php

namespace Modules\Product\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Category\app\Http\Requests\CategoryStoreRequest;
use Modules\Product\app\Http\Requests\ProductStoreRequest;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Resources\ProductResource;

class ProductApiController extends Controller
{
    public array $data = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $request->validated($request->all());
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')
                ->toMediaCollection('products');
        } else {
            return response()->json([
                "message" => "The image field is required.",
                "errors" => [
                    "image" => [
                        "The image field is required."
                    ]
                ]
            ], 422);
        }
        return new ProductResource($product);

//        return response()->json($this->data);
    }

    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, $id)
    {
        $request->validated($request->all());
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')
                ->toMediaCollection('products');
        }
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => 'Product Deleted'
        ]);
    }
}
