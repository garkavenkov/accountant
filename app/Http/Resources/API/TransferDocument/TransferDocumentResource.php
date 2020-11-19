<?php

namespace App\Http\Resources\API\TransferDocument;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\DocumentItem\DocumentItemResource;

class TransferDocumentResource extends JsonResource
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
            'department_gives_id'   =>  $this->debet_id,
            'department_gives'      =>  $this->department_gives->name,
            'employee_gives_id'     =>  $this->debet_person_id,
            'employee_gives'        =>  $this->employee_gives->full_name,
            'department_takes_id'   =>  $this->credit_id,
            'department_takes'      =>  $this->department_takes->name,
            'employee_takes_id'     =>  $this->credit_person_id,
            'employee_takes'        =>  $this->employee_takes->full_name,
            
            // 'purchaseSum'           =>  number_format($this->sum1, 2, '.', ' '),
            // 'retailSum'             =>  number_format($this->sum2, 2, '.', ' '), 
            // 'gain'                  =>  number_format($this->sum2 - $this->sum1, 2, '.', ' '),
            'given_sum'             =>  (float) $this->sum1,
            'taken_sum'             =>  (float) $this->sum2, 
            'gain'                  =>  (float) $this->sum2 - $this->sum1,
            'items'                 =>  DocumentItemResource::collection($this->whenLoaded('items')),
            // 'items'                 =>  DocumentItemResource::collection($this->items),            
            'status'                =>  (int) $this->status,
        ];
    }
}
