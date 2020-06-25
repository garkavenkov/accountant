<?php

namespace App\Http\Resources\API\Department;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Department\DepartmentWithEmployeesResource;

class DepartmentResource extends JsonResource
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
            'id'            =>  $this->id,
            'branch_id'     =>  $this->branch->id,
            'branch'        =>  $this->branch->name,
            'name'          =>  $this->name,
            'description'   =>  $this->description,
            'employees'     =>  DepartmentWithEmployeesResource::collection($this->whenLoaded('employees')),
            'opened'        =>  Carbon::parse($this->opened)->formatLocalized('%d.%m.%Y'),
            'closed'        =>  $this->closed ? Carbon::parse($this->closed)->formatLocalized('%d.%m.%Y') : null,
        ];
    }
}
