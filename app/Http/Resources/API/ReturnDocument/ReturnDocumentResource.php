<?php

namespace App\Http\Resources\API\ReturnDocument;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnDocumentResource extends JsonResource
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
            'branch_id'             =>  $this->department->branch->id,
            'branch'                =>  $this->department->branch->name,
            'department_id'         =>  $this->debet_id,
            'department'            =>  $this->department->name,            
            'employee_id'           =>  $this->debet_person_id,
            'employee_full_name'    =>  $this->employee->full_name,

            'supplier_id'           =>  $this->credit_id,
            'supplier'              =>  $this->supplier->name,

            'retailSum'             =>  (float) $this->sum1,
            'purchaseSum'           =>  (float) $this->sum2, 
            'return'                =>  (float) $this->sum1 - $this->sum2,
            
            // 'items'                 =>  DocumentItemResource::collection($this->whenLoaded('items')),
            // 'items'                 =>  DocumentItemResource::collection($this->items),
            // 'isPaid'                =>  (boolean) $this->isPaid,
            'statusCode'            =>  (int) $this->status,
            // 'payments'              =>  PaymentResource::collection($this->whenLoaded('payments'))
        ];
    }
}
