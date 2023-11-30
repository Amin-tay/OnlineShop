<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Resources\CategoryResource;
use Modules\DiscountCode\app\Models\DiscountCode;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderProduct;
use Modules\Order\app\Resources\OrderResource;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Resources\ProductResource;
use Modules\User\app\Http\Requests\AddToCartRequest;
use Modules\User\app\Http\Requests\DiscountCodeUsageRequest;
use Modules\User\app\Models\Cart;
use Modules\User\app\Models\UserCode;
use Modules\User\app\Resources\AddToCartResource;
use function PHPUnit\Framework\equalToWithDelta;

class HomeApiController extends Controller
{
    use HttpResponses;

    public function getCartRecord($user_id, $product_id)
    {
        return Cart::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();
    }

    public function getSumPrice($cartRecords)
    {
        $sumPrice = 0;
        foreach ($cartRecords as $cartRecord) {
            $sumPrice += (int)$cartRecord->quantity * (float)$cartRecord->product->price;
        }
        return $sumPrice;
    }

    public function getUserCartRecords($user_id)
    {
        return Cart::where('user_id', $user_id)->get();
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

    public function order(Request $request)
    {
        if (Auth::user()->hasAnyRole('superAdmin', 'normalAdmin')) {
            return $this->error401('Admins are not allowed to this action');
        }
        $user = Auth::user();
        $cartRecords = Cart::where('user_id', $user->id)->get();

        if ($cartRecords == null) {
            return response()->json([
                'message' => 'The Cart is empty'
            ], 406);
        }
        $sumPrice = $this->getSumPrice($cartRecords);
        $finalPrice = $sumPrice;

        foreach ($cartRecords as $cartRecord) {
            if ((int)$cartRecord->quantity > (int)$cartRecord->product->quantity) {
                return response()->json([
                    'message ' => $cartRecord->product->name . " quantity is not enough"
                ], 406);
            }
        }

        $userCode = UserCode::where('user_id', $user->id)->first();
        $discountCodeId = -1;

        if ($userCode != null) {

            $discountCode = $userCode->discountCode;
            $discountCodeId = $discountCode->id;

            if ($discountCode->quantity != -1 && $discountCode->used_number >= $discountCode->quantity) {
                return $this->error422("Discount Code can not be used anymore");
            }

            //todo create function
            if ($discountCode->discount_type == 'fixed') {
                $finalPrice -= (int)$discountCode->discount_amount;
            } else {
                $finalPrice = round(((100 - $discountCode->discount_amount) * $sumPrice / 100), 2);
            }

            $discountCode->used_number += 1;
            $discountCode->update();

        }
        $userCode->delete();
        Cart::where('user_id', $user->id)->delete();

        $order = Order::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address,
            'phone' => $user->phone,
            'payment_status' => 'cash',
            'order_status' => 'pending',
            'sum_price' => $sumPrice,
            'discount_code' => $discountCodeId,
            'final_price' => $finalPrice,
        ]);
        foreach ($cartRecords as $cartRecord) {
            $product = $cartRecord->product;
            $product->quantity = (int)$product->quantity - (int)$cartRecord->quantity;
            $product->update();
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cartRecord->quantity,
                'price' => $product->price,
            ]);
        }
        return response()->json([
            'message' => "Order submitted",
        ]);

    }

    public function allUserOrders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        if (!count($orders)) {
            return response()->json(['message' => 'Orders is empty'], 406);
        }
        return OrderResource::collection($orders);
    }

    public function showUserOrder($id)
    {

        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'message' => "Order not found"
            ], 404);
        }
        if ($order->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'You are not allowed'
            ], 403);
        }
        return new OrderResource($order);
    }

    public function viewAllCategories()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function viewAllProducts()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function viewCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => "Category Not found"], 404);
        }

        return new CategoryResource($category);
    }

    public function viewProduct($id)
    {

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => "Product Not found"], 404);
        }
        return new ProductResource($product);

    }

}
