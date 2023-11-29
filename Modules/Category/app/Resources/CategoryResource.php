<?php

namespace Modules\Category\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' =>$this->id,
            'name' => $this->name,
            'products_count' => count($this->products),
            'image' => $this->getFirstMediaUrl('categories')
        ];
    }
}
