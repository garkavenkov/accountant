<?php

namespace App\Http\Resources\API\Payment;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentIncomeDocumentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($document) {
            return [
                'id'            =>  (int) $document->id,
                'date'          =>  Carbon::parse($document->date)->formatLocalized('%d.%m.%Y'),
                'number'        =>  $document->number,
                'department'    =>  $document->department->name,
                'amount'        =>  (float) $document->sum1
            ];
        })->all();;
    }
}
