<?php

namespace Modules\Category\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Category\app\Http\Requests\CategoryStoreRequest;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Resources\CategoryResource;


class CategoryApiController extends Controller
{
    use HttpResponses;

    public array $data = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Show the specified resource.
     */
    public function show($category)
    {
        $category = Category::find($category);
        if (!$category) {
            return $this->error404('Category not found');
        }
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */

    public function store(CategoryStoreRequest $request)
    {
//        $request->validated($request->all());
        if (!Auth::user()->hasPermissionTo('add category')) {
            return $this->error401('You are not allowed to Add category');
        }

        $category = Category::create([
            'name' => $request->name
        ]);

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
        }
        return new CategoryResource($category);
    }

    public function update(CategoryStoreRequest $request, $category)
    {
        if (!Auth::user()->hasPermissionTo('edit category')) {
            return $this->error401('You are not allowed to Edit category');
        }

        $category = Category::find($category);
        if (!$category) {
            return $this->error404("Category not found");
        }
//        $request->validated($request->all());

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
    public function destroy($category)
    {
        if (!Auth::user()->hasPermissionTo('delete category')) {
            return $this->error401('You are not allowed to delete category');
        }

        $category = Category::find($category);

        if (!$category) {
            return $this->error404('Category not found');
        }
        $category->delete();
        return response()->json([
            'message' => 'Category Deleted'
        ]);

//        return response()->json($this->data);
    }
}
