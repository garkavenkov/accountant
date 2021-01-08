<?php

namespace App\Http\Resources\API\CashExpense;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CashExpenseDocumentResourceCollection extends ResourceCollection
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
