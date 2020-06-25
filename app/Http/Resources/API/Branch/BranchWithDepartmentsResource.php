<?php

namespace App\Http\Resources\API\Branch;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchWithDepartmentsResource extends JsonResource
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
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'description'   =>  $this->description,
            'opened'        =>  Carbon::parse($this->opened)->formatLocalized('%d.%m.%Y'),
            'closed'        =>  $this->closed ? Carbon::parse($this->closed)->formatLocalized('%d.%m.%Y') : null,
        ];
    }
}
