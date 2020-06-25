<?php

namespace App\Http\Resources\API\Position;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Position\PositionWithEmployeesResource;

class PositionResource extends JsonResource
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
            'id'            =>  (int) $this->id,
            'name'          =>  $this->name,
            'description'   =>  $this->description,
            'employees'     =>  PositionWithEmployeesResource::collection($this->whenLoaded('employees')),
        ];
    }
}
