<?php

namespace App\Http\Resources\API\RestType;

use Illuminate\Http\Resources\Json\JsonResource;

class RestTypeResource extends JsonResource
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
            'code'          =>  $this->code,
            'name'          =>  $this->name,
            'description'   =>  $this->description
        ];
    }
}
