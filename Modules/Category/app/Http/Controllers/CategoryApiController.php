<?php

namespace Modules\Category\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Category\app\Http\Requests\CategoryStoreRequest;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Resources\CategoryResource;


class CategoryApiController extends Controller
{
    public array $data = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return CategoryResource::collection($categories);
//        return response()->json([
//                'data' => [... CategoryResource::collection(Category::all())],
//            ]
//            , 200);

    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Show the specified resource.
     */
    public function show(Category $category)
    {
//        $category = Category::find($category);
        return new CategoryResource($category);

//        return response()->json($this->data);
    }

    /**
     * Update the specified resource in storage.
     */

    public function store(CategoryStoreRequest $request)
    {
        $request->validated($request->all());

        $category = Category::create([
            'name' => $request->name
        ]);
        if ($request->hasFile('image')) {
//            return response()->json();
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
        }
        return new CategoryResource($category);
//        return response()->json($this->data);
    }

    public function update(CategoryStoreRequest $request,  $category)
    {
        //
//        return response()->json(['data' => 'data']);
        $category = Category::find($category);
        $request->validated($request->all());

//        return new CategoryResource($category);

        $category->update([
            'name' => $request->name,
        ]);

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')
                ->toMediaCollection('categories');
        }
        return new CategoryResource($category);

//        return response()->json($this->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        //
        $category->delete();
        return response()->json([
            'message' => 'Category Deleted'
        ]);

//        return response()->json($this->data);
    }
}
