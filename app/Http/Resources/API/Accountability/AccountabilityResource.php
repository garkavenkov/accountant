<?php

namespace App\Http\Resources\API\Accountability;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        switch ($this->status) {
            case 0:
                $status = 'Новый';
                break;
            case 1:
                $status = 'Проведен';
                break;
            case 2:
                $status = 'Закрыт';
                break;
                
            default:
                $status = 'Не определен';
                break;
        }

        return [
            'id'                    =>  (int)   $this->id,
            'date'                  =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'operationId'           =>  (int)   $this->operation_id,
            'number'                =>  $this->number,
            'cashId'                =>  (int)   $this->debet_id,
            'cash'                  =>  $this->cash_debet->name,
            'employeeId'            =>  (int)   $this->credit_id,
            'employeeFullName'      =>  $this->employee->full_name,
            'purpose'               =>  $this->purpose,
            'amount'                =>  (float) $this->debet,            
            'statusCode'            =>  (int)   $this->status,
            'status'                =>  $status,
            'userId'                =>  (int)   $this->user_id,
            'items'                 =>  AccountabilityItemResource::collection($this->whenLoaded('items'))
        ];
    }
}
