<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static $wrap = 'order';
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return[
            'id'=>$this->resource->id,
            'order_description'=>$this->resource->order_description,
            'product'=>$this->resource->product,
            'quantity'=>$this->resource->quantity,
            'supplier'=>$this->resource->supplier,
            'user'=> new UserResource($this->resource->user),
        ];
    
    }
}
