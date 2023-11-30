<?php

namespace Modules\DiscountCode\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\DiscountCode\app\Http\Requests\DiscountCodeRequest;
use Modules\DiscountCode\app\Models\DiscountCode;
use Modules\DiscountCode\app\Resources\DiscountCodeResource;

class DiscountCodeApiController extends Controller
{
    public array $data = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discountCodes = DiscountCode::all();
        return DiscountCodeResource::collection($discountCodes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountCodeRequest $request)
    {
        $request->validated($request->all());

        $quantity = empty($request->quantity) ? -1 : $request->quantity;
//        $quantity = $request->quantity ?? -1;

        $discountCode = DiscountCode::create([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'quantity' => $quantity,
            'used_number' => 0,
        ]);

        return new DiscountCodeResource($discountCode);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $discount_code = DiscountCode::find($id);
        if (!$discount_code) {
            return response()->json(['message' => 'Discount code not found'], 404);
        }
        return new DiscountCodeResource($discount_code);
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(DiscountCodeRequest $request, $id)
//    {
//        $request->validated($request->all());
//        $discount_code = DiscountCode::findOrFail($id);
//
//        return new DiscountCodeResource($discount_code);
//
//
//    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy($id): JsonResponse
//    {
//        //
//
//        return response()->json($this->data);
//    }
}
