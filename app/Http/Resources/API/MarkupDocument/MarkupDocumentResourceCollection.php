<?php

namespace App\Http\Resources\API\MarkupDocument;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MarkupDocumentResourceCollection extends ResourceCollection
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
