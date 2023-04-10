<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'supplier';
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return[
            'id'=>$this->resource->id,
            'supplier_name'=>$this->resource->supplier_name,
            'country'=>$this->resource->country,
        ];
    }
}
