<?php

namespace App\Http\Resources\API\DepartmentTurns;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentTurnsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return [
            // 'id'            =>  (int)   $this->id,
            'departmentId'  =>  (int)   $this->departmentId,
            'department'    =>  $this->department,
            'date'          =>  $this->date,
            'incomeRest'    =>  (float) $this->incomeRest,
            'credit'        =>  [
                'total'     =>  (float) $this->credit->total,
                'income'    =>  (float) $this->credit->income,
                'transfer'  =>  (float) $this->credit->transfer,
                'markup'    =>  (float) $this->credit->markup,
            ],
            'debet'         =>  [
                'total'     =>  (float) $this->debet->total,
                'sales'     =>  (float) $this->debet->sales,
                'transfer'  =>  (float) $this->debet->transfer,
                'markdown'  =>  (float) $this->debet->markdown,
                'writedown' =>  (float) $this->debet->writedown,
                'expense'   =>  (float) $this->debet->expense,
            ],
            'outcomeRest'   =>  (float) $this->outcomeRest
        ];
    }
}
