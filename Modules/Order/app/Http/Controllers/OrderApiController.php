<?php

namespace Modules\Order\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\app\Models\Cart;
use Modules\DiscountCode\app\Models\UserCode;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderProduct;
use Modules\Order\app\Resources\OrderResource;
use function response;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;


    public function getSumPrice($cartRecords)
    {
        $sumPrice = 0;
        foreach ($cartRecords as $cartRecord) {
            $sumPrice += (int)$cartRecord->quantity * (float)$cartRecord->product->price;
        }
        return $sumPrice;
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

    public function allOrders()
    {
        $orders = Order::all();
        if (!count($orders)) {
            return response()->json(['message' => 'No Order Found!'], 404);
        }
        return OrderResource::collection($orders);
    }

    public function showOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found']);
        }
        return new OrderResource($order);
    }

    public function changeOrderStatus(Request $request, $id)
    {

        $request->validate([
            'status' => ['required'],
        ]);

        $user = Auth::user();
        $order = Order::find($id);

        if (!$user->hasPermissionTo('change order status')) {
            return response()->json(['message' => "You are not allowed to change order status"]);
        }

        if (!$order) {
            return response()->json(['message' => "Order not found"], 404);
        }

        $order->order_status = $request->status;
        $order->update();

        return new OrderResource($order);

    }
}
