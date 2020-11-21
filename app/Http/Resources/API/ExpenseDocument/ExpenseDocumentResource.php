<?php

namespace App\Http\Resources\API\ExpenseDocument;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\DocumentItem\DocumentItemResource;

class ExpenseDocumentResource extends JsonResource
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
            'id'                    =>  (int)   $this->id,
            // 'date'                  =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'date'                  =>  $this->date,
            'number'                =>  $this->number,
            'branch_id'             =>  $this->department->branch->id,
            'branch'                =>  $this->department->branch->name,
            'department_id'         =>  $this->debet_id,
            'department'            =>  $this->department->name,            
            'employee_id'           =>  $this->debet_person_id,
            'employee_full_name'    =>  $this->employee->full_name,
            'expense_sum'           =>  (float) $this->sum2,            
            'items'                 =>  DocumentItemResource::collection($this->whenLoaded('items')),
            'status'                =>  (int) $this->status,            
        ];
    }
}
