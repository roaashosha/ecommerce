<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user"=>[
                "id"=>$this->user->id,
                "name"=> $this->user->first_name . ' ' . $this->user->last_name,
            ],
            "desc"=>$this->desc,
            "date"=>$this->update_at
        ];
    }
}
