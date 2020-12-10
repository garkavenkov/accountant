<?php

namespace App\Http\Resources\API\Employee;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Employee\EmployeeSalaryResource;

class EmployeeResource extends JsonResource
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
            'surname'       =>  $this->surname,
            'name'          =>  $this->name,
            'patronymic'    =>  $this->patronymic,
            'branch_id'     =>  $this->department->branch->id,
            'branch'        =>  $this->department->branch->name,
            'department_id' =>  $this->department_id,
            'department'    =>  $this->department->name,
            'position_id'   =>  $this->position_id,
            'position'      =>  $this->position->name,
            'address'       =>  $this->address,
            'salary'        =>  EmployeeTariffRatesResource::collection($this->whenLoaded('tariffRates')),
            'birthdate'     =>  Carbon::parse($this->birthdate)->formatLocalized('%d.%m.%Y'),
            'hired'         =>  Carbon::parse($this->hired)->formatLocalized('%d.%m.%Y'),
            'fired'         =>  $this->fired ? Carbon::parse($this->fired)->formatLocalized('%d.%m.%Y') : null,
        ];
    }
}
