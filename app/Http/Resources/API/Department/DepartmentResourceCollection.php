<?php

namespace App\Http\Resources\API\Department;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentResourceCollection extends ResourceCollection
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
                'branch_id'     =>  (int) $item->branch->id,
                'branch'        =>  $item->branch->name,
                'name'          =>  $item->name,
                'description'   =>  $item->description,
                'opened'        =>  Carbon::parse($item->closed)->formatLocalized('%d.%m.%Y'),
                'closed'        =>  $item->closed ? Carbon::parse($item->closed)->formatLocalized('%d.%m.%Y') : null,
            ];
        })->all();
    }
}
