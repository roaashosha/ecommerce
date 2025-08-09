<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "country_name"=>$this->country->name,
            "governorate_name"=>$this->governorate->name,
            "city_name"=>$this->city->name,
            "region_name"=>$this->region->name,
            "street"=>$this->street,
            "house_no"=>$this->house_no,
            "zipcode"=>$this->zipcode->name,
            "type"=>$this->type
        ];
    }
}
