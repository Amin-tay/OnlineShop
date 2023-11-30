<?php

namespace Modules\DiscountCode\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\DiscountCode\app\Http\Requests\DiscountCodeRequest;
use Modules\DiscountCode\app\Http\Requests\DiscountCodeUsageRequest;
use Modules\DiscountCode\app\Models\DiscountCode;
use Modules\DiscountCode\app\Models\UserCode;
use Modules\DiscountCode\app\Resources\DiscountCodeResource;

class DiscountCodeApiController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */

    public function addDiscountCode(DiscountCodeUsageRequest $request)
    {
        if (Auth::user()->hasAnyRole('superAdmin', 'normalAdmin')) {
            return $this->error401('Admins are not allowed to this action');
        }
        $user = Auth::user();
        $discountCode = DiscountCode::where('code', $request->code)->first();
        $userCodeRecord = UserCode::where('user_id', $user->id)->first();

        if ($discountCode == null) {
            return $this->error422('Discount Code not found!');
        }

        if ($discountCode->quantity != -1 && $discountCode->used_number >= $discountCode->quantity) {
            return $this->error422("Discount Code can not be used anymore");
        }

        if ($userCodeRecord != null) {
            return $this->error422('You already selected a Discount Code');
        }

        $userCode = UserCode::create([
            'user_id' => $user->id,
            'discount_code_id' => $discountCode->id,
        ]);

        return response()->json([
            'message' => 'Discount Code added',
        ]);
    }

    public function removeDiscountCode(Request $request)
    {
        if (Auth::user()->hasAnyRole('superAdmin', 'normalAdmin')) {
            return $this->error401('Admins are not allowed to this action');
        }
        $user = Auth::user();
        $userCodeRecord = UserCode::where('user_id', $user->id)->first();

        if ($userCodeRecord == null) {
            return $this->error422('You have no Discount Code');
        }
        $userCodeRecord->delete();

        return response()->json([
            'message' => 'Discount Code removed',
        ]);

    }

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
