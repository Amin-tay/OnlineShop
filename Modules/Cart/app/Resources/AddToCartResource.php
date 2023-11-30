<?php

namespace Modules\Cart\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddToCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
//            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'product_price' => $this->product->price,
            'quantity' => $this->quantity,
        ];
    }
}
