<?php

namespace App\Http\Resources\API\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeTariffRatesResource extends JsonResource
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
            'id'                =>  (int)   $this->id,
            'date'              =>  $this->date,
            'salaryTypeId'      =>  (int)   $this->salary_type_id,
            'salaryCode'        =>  $this->type->code,
            'salaryName'        =>  $this->type->name,
            'salaryDescription' =>  $this->type->description,
            'amount'            =>  (float) $this->amount
        ];
    }
}
