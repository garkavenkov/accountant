<?php

namespace App\Http\Resources\API\Employee;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeResourceCollection extends ResourceCollection
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
                'id'            =>  (int)   $item->id,
                'surname'       =>  $item->surname,
                'name'          =>  $item->name,
                'patronymic'    =>  $item->patronymic,
                'full_name'     =>  $item->full_name,
                'branch_id'     =>  (int)   $item->department->branch->id,
                'branch'        =>  $item->department->branch->name,
                'department_id' =>  (int)   $item->department->id,
                'department'    =>  $item->department->name,
                'position_id'   =>  (int)   $item->position->id,
                'position'      =>  $item->position->name,
                'hired'         =>  Carbon::parse($item->hired)->formatLocalized('%d.%m.%Y'),
                'fired'         =>  $item->fired ? Carbon::parse($item->fired)->formatLocalized('%d.%m.%Y') : null
            ];  
        })->all();
    }
}
