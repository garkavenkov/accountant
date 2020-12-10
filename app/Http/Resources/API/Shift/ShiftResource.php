<?php

namespace App\Http\Resources\API\Shift;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Shift\ShiftEmployeesResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            =>  $this->id,
            'departmentId'  =>  $this->department_id,
            'department'    =>  $this->department->name,
            'employees'     =>  ShiftEmployeesResource::collection($this->whenLoaded('employees')),
            'dateBegin'     =>  Carbon::parse($this->date_begin)->formatLocalized('%d.%m.%Y'),
            'dateEnd'       =>  Carbon::parse($this->date_end)->formatLocalized('%d.%m.%Y'),
        ];
    }
}
