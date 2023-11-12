<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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

    public function viewCategory($id)
    {
        $category = Category::find($id);
        $products = $category->products;
        return view('user.viewCategory', compact('category', 'products'));
    }

    public function viewProduct($id)
    {
        $product = Product::find($id);
        //        dd($product->description);
        $quantity = 0;
        // dd(session('cart')[$id]);
        if (!empty(session('cart')) && !empty(session('cart')[$id])) {
            $quantity = session('cart')[$id];
        }
        return view('user.viewProduct', compact('product', 'quantity'));
    }

    public function notEnoughQuantity($productId, $quantity)
    {
        $product = Product::find($productId);
        return $product->quantity < (int)$quantity;
    }
    public function addToCart(Request $request)
    {

        if (Auth::user()->user_type == '1') {
            return redirect()->back()->with('warning', "You are an Admin, You cannot buy stuff :)");
        }

        if (empty(session('cart'))) {
            session()->put('cart', []);
        }

        $productId = $request->productId;
        $product = Product::find($productId);
        $quantity =  $request->quantity;
        $cart = session('cart');

        if (empty($quantity)) {
            return redirect()->back()->with('danger', 'You should enter quantity!');
        }

        //        dd(empty($cart->$productId));
        // if (notEnoughQuantity($productId, $quantity)) {
        //     return redirect()->back()->with('danger', 'Sorry, Not enough Quantity for this product!');
        // }

        if ($product->quantity < (int)$quantity) {
            return redirect()->back()->with('danger', 'Sorry, Not enough Quantity for this product!');
        }
        $cart[$productId] = $quantity;
        // if (empty($cart->$productId)) {
        //     $cart[$productId] = $quantity;
        // } else {
        //     $cart[$productId] += $quantity;
        // }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', "Product Added to Cart!");
    }

    public function getTotalCost($cart)
    {

        //  dd($cart)   ;
        $totalCost = 0;
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            $totalCost += ((float)$product->price * (float) $quantity);
        }
        //  dd($totalCost);
        return $totalCost;
    }
    public function viewCart()
    {
        // dd(session());
        // dd(round(44.35 * 15 / 100,2));
        $products = [];
        $cart = session('cart');
        $totalCost = 0;
        // dd($cart);

        if (!empty($cart)) {
            foreach ($cart as $key => $value) {
                $product = Product::find($key);
                $product->quantity = $value;
                $products[] = $product;
            }
            $totalCost = $this->getTotalCost($cart);
            $this->refreshCart();
        }

        // dd($products);
        // dd(session('cart'));

        return view('user.viewCart', compact('products', 'totalCost'));
    }
    public function getfinalPrice($totalCost, $discount_code)
    {
        if ($discount_code->discount_type == 'fixed') {
            return  $totalCost - $discount_code->discount_amount;
        } else {
            return round(($discount_code->discount_amount * $totalCost / 100), 2);
        }
        // dd($final_price);
    }

    public function getExplainCode($discount_code)
    {
        if ($discount_code->discount_type == 'fixed') {
            return $discount_code->discount_amount . "$ Discount!";
        } else {
            return $discount_code->discount_amount . "% Discount!";
        }
    }
    public function addDiscountCode(Request $request)
    {

        $totalCost = $this->getTotalCost(session('cart'));
        $code = $request->code;
        $discount_code = DiscountCode::where('code', '=', $code)->first();

        if ($discount_code->quantity != -1 &&  $discount_code->quantity >=  $discount_code->used_number) {
            return redirect()->back()->with('error', 'Code Can not be used any more!');
        } else {

            $finalPrice =  $this->getfinalPrice($totalCost, $discount_code);
            $explainCode = $this->getExplainCode($discount_code);

            session()->put('discount_code', $discount_code);
            session()->put('discount_code_id', $discount_code->id);
            session()->put('explainCode', $explainCode);
            session()->put('final_price', $finalPrice);

            return redirect()->back()
                ->with('success', 'Discount Code Added!');
        }
    }
    public function removeDiscountCode(Request $request)
    {
        session()->forget('discount_code');
        session()->forget('discount_code_id');
        session()->forget('explainCode');
        session()->forget('final_price');

        return redirect()->back()
            ->with('warning', 'Discount Code Deleted!');
    }
    public function refreshCart()
    {
        if (session()->has('discount_code')) {
            $cart = session('cart');
            $sum_price = $this->getTotalCost($cart);
            $discount_code = session('discount_code');
            session()->put('final_price', $this->getfinalPrice($sum_price, $discount_code));
        }
    }
    public function order(Request $request)
    {
        $user = Auth::user();
        $cart = session('cart');
        // session('cart')['6'] = '44';
        // $cart['6'] = '44';
        // session()->put('cart', $cart);

        // return redirect()->back()->with('success', 'test');
        // dd(session('cart'), $cart);
        //todo check for avaliable quanitity and decrease 
        // dd(empty($cart));


        if (empty($cart)) {
            return redirect()->back()->with('danger', 'The Card is Empty!');
        }

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product->quantity < $quantity) {
                $old_quantity = $quantity;
                $cart[$productId] = $product->quantity;
                session()->put('cart', $cart);

                return redirect()->back()->with('danger', $product->name . " has no enough qunatity! Decreased order quantity from " . $old_quantity . " to " . $product->quantity);
            }
        }


        $sum_price = $this->getTotalCost($cart);
        $discount_code_id = -1;
        $final_price = $sum_price;
        if (session()->has('discount_code')) {
            $discount_code_id = session('discount_code_id');
            $discount_code = session('discount_code');
            $final_price = $this->getfinalPrice($sum_price, $discount_code);
            $discount_code->used_number += 1;
            $discount_code->update();

            session()->forget('discount_code');
            session()->forget('discount_code_id');
            session()->forget('explainCode');
            session()->forget('final_price');
        }



        //        dd($sum_price);
        $order = Order::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address,
            'phone' => $user->phone,
            'payment_status' => $request->payment_status,
            'order_status' => 'pending',
            'sum_price' => $sum_price,
            'discount_code' => $discount_code_id,
            'final_price' => $final_price,
        ]);

        foreach ($cart as $key => $value) {
            $product = Product::find($key);
            $product->quantity = (int) $product->quantity - (int)$value;
            $product->update();
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $key,
                'quantity' => $value,
                'price' => $product->price,
            ]);
        }

        session()->put('cart', []);

        return redirect('thank_you');
    }

    public function thankYou()
    {
        return view('user.thankYou');
    }

    public function viewOrders()
    {
        $orders = Auth::user()->orders;

        // dd(gettype($orders),$orders);
        // $orders = array_reverse(array(Auth::user()->orders));
        foreach ($orders as $order) {
            // dd($order);
            $order->formated_date = date("D d/m/Y ", strtotime($order->created_at));
            $order->order_color = $this->getCssColor($order->order_status);
        }
        return view('user.viewOrders', compact('orders'));
    }

    public function showOrder(string $id)
    {
        $order = Order::find($id);
        if ($order->user->id != Auth::user()->id) {
            abort(404);
        }
        $products = $order->getProducts();
        $order->order_color = $this->getCssColor($order->order_status);

        return view('user.showOrder', compact('order', 'products'));
    }
}
