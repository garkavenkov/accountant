<?php

namespace App\Http\Resources\API\TransferDocument;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferDocumentResourceCollection extends ResourceCollection
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
