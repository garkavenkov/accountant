<?php

namespace App\Http\Resources\API\Payment;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Payment\PaymentIncomeDocumentResourceCollection;

class PaymentResource extends JsonResource
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
            'id'            =>  (int)   $this->id,
            'date'          =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'operation_id'  =>  (int)   $this->operation_id,
            'number'        =>  $this->number,
            'cash_id'       =>  (int)   $this->cash->id,
            'cash'          =>  $this->cash->name,
            'supplier_id'   =>  (int)   $this->supplier->id,
            'supplier'      =>  $this->supplier->name,
            'purpose'       =>  $this->purpose,
            'amount'        =>  (float) $this->debet,            
            'status_code'   =>  (int)   $this->status,
            'user_id'       =>  (int)   $this->user_id,
            'documents'     =>  new PaymentIncomeDocumentResourceCollection($this->whenLoaded('documents'))
        ];
    }
}
