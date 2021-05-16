<?php

namespace App\Http\Resources\API\LoanContract;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\LoanContract\LoanRepaymentResource;

class LoanContractResource extends JsonResource
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
            'dateBegin'         =>  Carbon::parse($this->date_begin)->formatLocalized('%d.%m.%Y'),
            'dateEnd'           =>  $this->date_end !== null ? Carbon::parse($this->date_end)->formatLocalized('%d.%m.%Y') : null,
            'creditorId'        =>  $this->counterparty_id,
            'creditorName'      =>  $this->creditor->name,
            'creditorFullName'  =>  $this->creditor->full_name,
            'currencyId'        =>  $this->currency_id,
            'currencyCode'      =>  $this->currency->code,
            'currencyName'      =>  $this->currency->name,
            'amount'            =>  $this->amount,
            // 'repayments'        =>  $this->repayments
            'repayments'        =>  LoanRepaymentResource::collection($this->whenLoaded('repayments')),
        ];
    }
}
