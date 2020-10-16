<?php

namespace App\Http\Resources\API\SalesRevenue;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesRevenueResource extends JsonResource
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
            'operation_id'      =>  (int) $this->operation_id,
            'date'              =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'number'            =>  $this->number,
            'department_id'     =>  (int) $this->debet_id,
            'department'        =>  $this->department->name,
            'cash_id'           =>  (int) $this->credit_id,
            'cash'              =>  $this->cash->name,
            'amount'            =>  (float) $this->credit,
            'status'            =>  $this->status
        ];
    }
}
