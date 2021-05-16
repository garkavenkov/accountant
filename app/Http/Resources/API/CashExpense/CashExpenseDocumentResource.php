<?php

namespace App\Http\Resources\API\CashExpense;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CashExpenseDocumentResource extends JsonResource
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
            "id"                =>  (int) $this->id,
            'operation_id'      =>  (int) $this->operation_id,
            'operation'         =>  $this->operation->name,
            'date'              =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'number'            =>  $this->number,
            'cash_id'           =>  (int) $this->debet_id,
            'cash'              =>  $this->cash_debet->name,
            'expense_id'        =>  (int) $this->credit_id,            
            'expense'           =>  $this->expense->name,
            'category_id'       =>  (int) $this->expense->owner_id,
            'category'          =>  $this->expense->category->name,
            'group_id'          =>  $this->expense->category->id,
            'group'             =>  $this->expense->category->group->name,
            'purpose'           =>  $this->purpose,
            'amount'            =>  (float) $this->debet,
            'status_code'       =>  (int) $this->status,
            // 'status'            =>  $status,
        ];
    }
}
