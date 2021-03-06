<?php

namespace App\Http\Resources\API\ExpenseProfitItem;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseItemResource extends JsonResource
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
            'code'      =>  $this->code,
            'name'      =>  $this->name
        ];
    }
}
