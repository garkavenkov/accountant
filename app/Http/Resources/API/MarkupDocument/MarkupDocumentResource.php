<?php

namespace App\Http\Resources\API\MarkupDocument;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\DocumentItem\DocumentItemResource;

class MarkupDocumentResource extends JsonResource
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
            'date'                  =>  $this->date,
            'number'                =>  $this->number,
            'documentTypeId'        =>  $this->document_type_id,
            'branchId'              =>  $this->department->branch->id,
            'branch'                =>  $this->department->branch->name,
            'departmentId'          =>  $this->debet_id,
            'department'            =>  $this->department->name,            
            'employeeId'            =>  $this->debet_person_id,
            'employeeFullName'      =>  $this->employee->full_name,
            'markupSum'             =>  (float) $this->sum2,            
            'items'                 =>  DocumentItemResource::collection($this->whenLoaded('items')),
            'status'                =>  (int) $this->status,      
        ];
    }
}
