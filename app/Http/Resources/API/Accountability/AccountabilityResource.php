<?php

namespace App\Http\Resources\API\Accountability;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountabilityResource extends JsonResource
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
            'id'                    =>  (int)   $this->id,
            'date'                  =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'operation_id'          =>  (int)   $this->operation_id,
            'number'                =>  $this->number,
            'cash_id'               =>  (int)   $this->debet_id,
            'cash'                  =>  $this->cash_debet->name,
            'employee_id'           =>  (int)   $this->credit_id,
            'employee_full_name'    =>  $this->employee->full_name,
            'purpose'               =>  $this->purpose,
            'amount'                =>  (float) $this->debet,            
            'status_code'           =>  (int)   $this->status,
            'user_id'               =>  (int)   $this->user_id,
            // 'documents'             =>  new PaymentIncomeDocumentResourceCollection($this->whenLoaded('documents'))
        ];
    }
}
