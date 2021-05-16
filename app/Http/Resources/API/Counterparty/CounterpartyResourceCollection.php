<?php

namespace App\Http\Resources\API\Counterparty;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CounterpartyResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'  =>  $this->collection
        ];
    }
}
