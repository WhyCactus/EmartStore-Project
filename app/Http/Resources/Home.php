<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Home extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->product_name,
            "original_price" => $this->original_price,
            "discounted_price" => $this->discounted_price,
            "image_url" => $this->image,
            "quantity_in_stock" => $this->quantity_in_stock,
            "category" => new Category($this->whenLoaded('category')),
            "brand" => new Brand($this->whenLoaded('brand')),
            "sold_count" => $this->sold_count,
        ];
    }
}
