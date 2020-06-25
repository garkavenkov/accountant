<?php

namespace App\Http\Resources\API\Position;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PositionResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($item) {
            return [
                'id'            =>  (int) $item->id,
                'name'          =>  $item->name,
                'description'   =>  $item->description
            ];
        })->all();
    }
}
