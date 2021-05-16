<?php

namespace App\Http\Resources\API\Counterparty;

use Illuminate\Http\Resources\Json\JsonResource;

class CounterpartyResource extends JsonResource
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
            'name'      =>  $this->name,
            'fullName'  =>  $this->full_name,
        ];
    }
}
