<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "product_name"=>$this->product->name,
            "offer_price"=>$this->offer_price,
            "price"=>$this->price,
            "total"=>$this->offer_price *$this->count
        ];
    }
}
