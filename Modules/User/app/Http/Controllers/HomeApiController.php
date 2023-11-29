<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Product\app\Models\Product;
use Modules\User\app\Http\Requests\AddToCartRequest;
use Modules\User\app\Models\Cart;
use Modules\User\app\Resources\AddToCartResource;
use function PHPUnit\Framework\equalToWithDelta;

class HomeApiController extends Controller
{
    public array $data = [];

    public function getCartRecord($user_id, $product_id)
    {
        return Cart::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();
    }

    public function getUserCartRecords($user_id)
    {
        return Cart::where('user_id', $user_id)->get();
    }

    public function error422($errorMessage)
    {
        return response()->json([
            'message' => $errorMessage,
            'errors' => [
                'product_id' => [$errorMessage]
            ]
        ], 422);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $request->validated($request->all());

        $user = Auth::user();

        $cartRecord = $this->getCartRecord($user->id, $request->product_id);

        if ($cartRecord != null) {
            $cartRecord->delete();
        }
        $product = Product::findOrFail($request->product_id);
        if ($product == null) {
            return $this->error422('Product not found');
        }
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return new AddToCartResource($cart);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => ['required']
        ]);

        $user = Auth::user();
        $cartRecord = $this->getCartRecord($user->id, $request->product_id);
        if ($cartRecord == null) {
            return $this->error422('This product is not in your cart');
        }

        $cartRecord->delete();
        return response()->json([
            'message' => 'Product Deleted From the Cart',
        ]);

    }

    public function viewCart()
    {
        $user = Auth::user();
        $cartRecords = $this->getUserCartRecords($user->id);
        $finalPrice = 0;
        foreach ($cartRecords as $cartRecord) {
            $finalPrice += (int)$cartRecord->quantity * (float)$cartRecord->product->price;
        }
        return response()->json([
            'data' => [...AddToCartResource::collection($cartRecords)],
            'final_price' => $finalPrice,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //

        return response()->json($this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        //

        return response()->json($this->data);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        //

        return response()->json($this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        //

        return response()->json($this->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        //

        return response()->json($this->data);
    }
}
