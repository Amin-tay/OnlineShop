<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\String_;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getCssColor($status)
    {
        switch ($status) {
            case 'pending':
                return 'bg-warning';

            case 'canceled':
                return 'bg-danger';

            case 'shipped':
                return 'bg-primary';

            case 'received':
                return 'bg-success';

            default:
                return 'bg-info';
        }
    }

    public function index()
    {
        $orders = Order::orderBy('id','desc')->get();
        // $orders = Order::all();
        foreach ($orders as $order) {
            $order->color = $this->getCssColor($order->order_status);
            $order->formated_date = date("D d/m/Y ", strtotime($order->created_at));

        }

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        $products = $order->getProducts();

        return view('admin.orders.show', compact('products', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeOrderStatus(Request $request)
    {


        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        $status = $request->input('status');


        $order->update([
            'order_status' => $status,
        ]);

//        return response()->json(['message' => $orderId]);
        $css_class = 'form-select ' . $this->getCssColor($status);

        return response()->json(['message' => 'Order status updated successfully',
            'css_class' => $css_class,
        ]);


    }
}
