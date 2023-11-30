<?php

namespace Modules\Order\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\app\Models\OrderProduct;
use Modules\Product\app\Resources\ProductResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $products = $this->getProducts();

        return [
            'user_id' => $this->user_id,
            'date' => $this->created_at,
            'address' => $this->address,
            'order_status' => $this->order_status,
            'sum_price' => $this->sum_price,
            'final_price' => $this->final_price,
            'discount_code' => $this->discount_code,
            ProductResource::collection($products)
        ];
    }
}
