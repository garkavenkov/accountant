<?php

namespace App\Http\Resources\API\CashProfit;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CashProfitDocumentResource extends JsonResource
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
            "id"                =>  (int) $this->id,
            'operation_id'      =>  (int) $this->operation_id,
            'operation'         =>  $this->operation->name,
            'date'              =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'number'            =>  $this->number,
            'cash_id'           =>  (int) $this->credit_id,
            'cash'              =>  $this->cash_credit->name,
            'profit_id'         =>  (int) $this->debet_id,
            'expense'           =>  $this->profit->name,
            'purpose'           =>  $this->purpose,
            'amount'            =>  (float) $this->credit,
            'status_code'       =>  (int) $this->status,
            // 'status'            =>  $status,
        ];
    }
}
