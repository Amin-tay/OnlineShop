<?php

namespace Modules\Order\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Resources\OrderResource;
use function response;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
