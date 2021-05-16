<?php

namespace App\Http\Resources\API\Currency;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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
            'number'    =>  $this->number,
            'name'      =>  $this->name
        ];
    }
}
