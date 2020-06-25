<?php

namespace App\Http\Resources\API\Supplier;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            =>  (int)   $this->id,
            'name'          =>  $this->name,
            'full_name'     =>  $this->full_name,
            'description'   =>  $this->description
        ];
    }
}
