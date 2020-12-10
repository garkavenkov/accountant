<?php

namespace App\Http\Resources\API\Salary;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SalaryResourceCollection extends ResourceCollection
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
            'data'      =>  $this->collection
        ];
    }
}
