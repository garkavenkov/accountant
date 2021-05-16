<?php

namespace App\Http\Resources\API\LoanContract;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanRepaymentResource extends JsonResource
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
            'id'        =>  (int)   $this->id,
            'date'      =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'number'    =>  $this->number,
            'cashId'    =>  $this->debet_id,
            'cash'      =>  $this->cash_debet->name,
            'amount'    =>  $this->debet,
            'purpose'   =>  $this->purpose
        ];
    }
}
