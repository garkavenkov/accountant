<?php

namespace App\Http\Resources\API\ExpenseProfitItem;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseItemResourceCollection extends ResourceCollection
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
            'data'  =>  $this->collection
        ];
    }
}
