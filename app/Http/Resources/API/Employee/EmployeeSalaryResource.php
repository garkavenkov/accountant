<?php

namespace App\Http\Resources\API\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeSalaryResource extends JsonResource
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
            'id'                =>  (int) $this->id,
            'date'              =>  $this->date,
            'employeeId'       =>  $this->employee_id,
            'salaryTypeId'    =>  $this->salary_type_id,
        ];
    }
}
