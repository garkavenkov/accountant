<?php

namespace App\Http\Resources\API\IncomeDocument;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IncomeDocumentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($doc) {
            return [
                'id'                    =>  (int)   $doc->id,
                'date'                  =>  Carbon::parse($doc->date)->formatLocalized('%d.%m.%Y'),
                'number'                =>  $doc->number,
                'supplier_id'           =>  (int) $doc->supplier->id,
                'supplier'              =>  $doc->supplier->name,
                'department_id'         =>  (int) $doc->credit_id,
                'department'            =>  $doc->department->name,
                'employee_id'           =>  (int) $doc->credit_person_id,
                'employee_full_name'    =>  $doc->employee->full_name,
                // 'sum1'                  =>  number_format($doc->sum1, 2),
                // 'sum2'                  =>  number_format($doc->sum2, 2), 
                // 'gain'                  =>  number_format($doc->sum2 - $doc->sum1, 2)
                'sum1'                  =>  (float) $doc->sum1, 
                'sum2'                  =>  (float) $doc->sum2,
                'gain'                  =>  (float) ($doc->sum2 - $doc->sum1),
                'isPaid'                =>  (boolean) $doc->isPaid,
                'status'                =>  $doc->status,
                'firstForm'             =>  $doc->firstForm,
                'bonus'                 =>  $doc->bonus
                // 'payments'              =>  PaymentResource::collection($doc->payments)
                // 'payments'              =>  PaymentResource::collection($doc->whenLoaded('payments'))
            ];
        })->all();
    }
}
