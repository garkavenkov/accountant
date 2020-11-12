<?php

namespace App\Http\Resources\API\IncomeDocument;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'number'        =>  $this->number,
            'cash_id'       =>  $this->cash->id,
            'cash'          =>  $this->cash->name,
            'amount'        =>  (float) $this->debet,
        ];
    }
}
