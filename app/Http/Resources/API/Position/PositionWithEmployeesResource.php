<?php

namespace App\Http\Resources\API\Position;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionWithEmployeesResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        return [
            'id'            =>  (int) $this->id,                
            'full_name'     =>  $this->full_name,
            'department'    =>  $this->department->name
        ];        
    }
}
