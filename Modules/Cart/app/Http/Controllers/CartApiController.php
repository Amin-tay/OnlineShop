<?php

namespace Modules\Cart\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\app\Http\Requests\AddToCartRequest;
use Modules\Cart\app\Models\Cart;
use Modules\Cart\app\Resources\AddToCartResource;
use Modules\Product\app\Models\Product;

class CartApiController extends Controller
{


    use HttpResponses;
    public function getSumPrice($cartRecords)
    {
        $sumPrice = 0;
        foreach ($cartRecords as $cartRecord) {
            $sumPrice += (int)$cartRecord->quantity * (float)$cartRecord->product->price;
        }
        return $sumPrice;
    }
    public function addToCart(AddToCartRequest $request)
    {
        if (Auth::user()->hasAnyRole('superAdmin', 'normalAdmin')) {
            return $this->error401('Admins are not allowed to this action');
        }
//
        $user = Auth::user();
        $product = Product::find($request->product_id);

//        $cartRecord = $this->getCartRecord($user->id, $request->product_id);
        $cartRecord = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartRecord != null) {
            $cartRecord->delete();
        }

        if (!$product) {
            return $this->error422('Product not found');
        }
//    return response()->json([$product]);
        if ($request->quantity > $product->quantity) {
            return response()->json([
                'message ' => $product->name . " quantity is not enough"
            ], 406);
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
        if (Auth::user()->hasAnyRole('superAdmin', 'normalAdmin')) {
            return $this->error401('Admins are not allowed to this action');
        }

        $request->validate([
            'product_id' => ['required']
        ]);

        $user = Auth::user();

//        $cartRecord = $this->getCartRecord($user->id, $request->product_id);

        $cartRecord = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

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
        if (Auth::user()->hasAnyRole('superAdmin', 'normalAdmin')) {
            return $this->error401('Admins are not allowed to this action');
        }

        $user = Auth::user();
        $cartRecords = Cart::where('user_id', $user->id)->get();

        if (!count($cartRecords)) {
            return response()->json([
                'message' => 'The cart is empty'
            ], 406);
        }
        $sumPrice = $this->getSumPrice($cartRecords);

        return response()->json([
            'data' => [...AddToCartResource::collection($cartRecords)],
            'sum_price' => $sumPrice,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cart::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cart::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('cart::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('cart::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
