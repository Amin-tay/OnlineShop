<?php

namespace Modules\DiscountCode\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return[
            'id' => $this->id,
            'code' => $this->code,
            'quantity' => $this->quantity,
            'used_number' => $this->used_number,
            'discount_type' => $this->discount_type,
            'discount_amount' => $this->discount_amount,
        ];
    }
}
