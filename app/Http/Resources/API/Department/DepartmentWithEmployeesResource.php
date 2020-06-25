<?php

namespace App\Http\Resources\API\Department;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentWithEmployeesResource extends JsonResource
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
            'id'        =>  $this->id,
            'full_name' =>  $this->full_name,
            'position'  =>  $this->position->name
        ];
    }
}
