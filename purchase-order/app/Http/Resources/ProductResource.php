<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'product';
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return[
            'id'=>$this->resource->id,
            'brand'=>$this->resource->brand,
            'product_type'=>$this->resource->product_type,
            'model'=>$this->resource->model,

            
        ];
    }
}
