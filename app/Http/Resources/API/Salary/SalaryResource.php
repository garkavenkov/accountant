<?php

namespace App\Http\Resources\API\Salary;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryResource extends JsonResource
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
            'id'                    =>  (int) $this->id,
            'operation_id'          =>  (int) $this->operation_id,
            'date'                  =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'number'                =>  $this->number,            
            'cash_id'               =>  (int) $this->debet_id,
            'cash'                  =>  $this->cash->name,
            'employee_id'           =>  (int) $this->credit_id,
            'employee_full_name'    =>  $this->employee->full_name,
            'purpose'               =>  $this->purpose,
            'amount'                =>  (float) $this->debet,
            'status'                =>  $this->status
        ];
    }
}
