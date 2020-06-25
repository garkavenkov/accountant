<?php

namespace App\Http\Resources\API\Branch;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BranchResourceCollection extends ResourceCollection
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
                'id'        =>  (int)   $item->id,
                'name'      =>  $item->name,
                'address'   =>  $item->address,
                'opened'    =>  Carbon::parse($item->opened)->formatLocalized('%d.%m.%Y'),
                'closed'    =>  $item->closed ? Carbon::parse($item->closed)->formatLocalized('%d.%m.%Y') : null
            ];
        })->all();
    }
}
