<?php

namespace Modules\Order\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\app\Models\Product;

class Order extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProducts()
    {
        $orderProducts = OrderProduct::where('order_id', $this->id)->get();
        $products = [];
        foreach ($orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            $product->quantity = $orderProduct->quantity;
            $product->price = $orderProduct->price;
            $products[] = $product;
        }
        return $products;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
//            ->withPivot('quantity');
    }

    public function order_products()
    {
        return $this->hasOne(OrderProduct::class);
    }
}

