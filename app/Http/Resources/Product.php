<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "image"=> $this->image,
            "name"=> $this->product_name,
            "sku"=> $this->product_code,
            "original_price"=> $this->original_price,
            "discounted_price"=> $this->discounted_price,
            "quantity_in_stock"=> $this->quantity_in_stock,
            "category_id"=> $this->category_id,
            "brand_id"=> $this->brand_id,
            "sold_count"=> $this->sold_count,
            "status"=> $this->status,
        ];
    }
}
