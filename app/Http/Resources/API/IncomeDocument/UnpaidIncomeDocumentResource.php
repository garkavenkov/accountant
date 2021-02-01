<?php

namespace App\Http\Resources\API\IncomeDocument;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UnpaidIncomeDocumentResource extends JsonResource
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
            'number'                =>  $this->number,
            'supplierId'            =>  (int) $this->supplier->id,
            'supplier'              =>  $this->supplier->name,
            'branchId'              =>  (int) $this->department->branch->id,
            'branch'                =>  $this->department->branch->name,
            'departmentId'          =>  (int) $this->credit_id,
            'department'            =>  $this->department->name,            
            // 'employee_id'           =>  $this->credit_person_id,
            // 'employee_full_name'    =>  $this->employee->full_name,
            // 'purchaseSum'           =>  number_format($this->sum1, 2, '.', ' '),
            // 'retailSum'             =>  number_format($this->sum2, 2, '.', ' '), 
            // 'gain'                  =>  number_format($this->sum2 - $this->sum1, 2, '.', ' '),
            'purchaseSum'           =>  (float) $this->sum1,
            // 'retailSum'             =>  (float) $this->sum2, 
            // 'gain'                  =>  (float) $this->sum2 - $this->sum1,
            // 'items'                 =>  DocumentItemResource::collection($this->whenLoaded('items')),
            // 'items'                 =>  DocumentItemResource::collection($this->items),
            // 'isPaid'                =>  (boolean) $this->isPaid,
            // 'status'                =>  (int) $this->status,
            // 'firstForm'             =>  (int) $this->firstForm,
            // 'bonus'                 =>  (int) $this->bonus
            // 'payments'              =>  PaymentResource::collection($this->whenLoaded('payments'))
        ];
    }
}
