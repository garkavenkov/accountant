<?php

namespace App\Http\Resources\API\Branch;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Branch\BranchEmployeesResource;
use App\Http\Resources\API\Branch\BranchWithDepartmentsResource;

class BranchResource extends JsonResource
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
            'name'          =>  $this->name,
            'address'       =>  $this->address,
            // 'departments'   =>  BranchWithDepartmentsResource::collection($this->whenLoaded('departments')),
            'departments'   =>  BranchWithDepartmentsResource::collection($this->departments),
            // 'departments'   =>  $this->departments,
            // 'employees'     =>  BranchWithEmployeesResource::collection($this->whenLoaded('employees')),
            'employees'     =>  BranchWithEmployeesResource::collection($this->employees),
            // 'employees'     =>  $this->employees,
            'cashes'        =>  $this->cashes,
            'opened'        =>  Carbon::parse($this->opened)->formatLocalized('%d.%m.%Y'),
            'closed'        =>  $this->closed ? Carbon::parse($this->closed)->formatLocalized('%d.%m.%Y') : null,
        ];
    }
}
