<?php

namespace App\Http\Resources\API\CashDocument;

use Carbon\Carbon;
use App\Models\CashDocument;
use Illuminate\Http\Resources\Json\JsonResource;

class CashDocumentResource extends JsonResource
{

    private $links = [];
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);      
        
        switch ($this->operation->code) {
            case 'payment':
                $debet_name     = $this->cash_debet->name;
                $credit_name    = $this->supplier->name;
                $this->links['original'] = "/payments/{$this->id}";
                break;
            case 'sales_revenue':
                $debet_name     = $this->department->name;
                $credit_name    = $this->cash_credit->name;
                $this->links['original'] = "sales-revenues/{$this->id}";
                break;

            case 'salary':
                $debet_name     = $this->cash_debet->name;
                $credit_name    = $this->employee->full_name;
                $this->links['original'] = "salaries/{$this->id}";
                break;
            
            case 'expense':
                $debet_name     = $this->cash_debet->name;
                $credit_name    = $this->expense->name;
                $this->links['original'] = "cash-expense-documents/{$this->id}";
                break;

            default:
                $debet_name     = 'undefined';
                $credit_name    = 'undefined';
                break;
        }

        switch ($this->status) {
            case 0:
                $status         = 'новый';
                break;
            case 1:
                $status         = 'проведен';
                break; 
            case 2:
                $status         = 'закрыт';
                break;
            
            default:
                $status         = 'undefined';
                break;
        }

        return [
            "id"                =>  (int) $this->id,
            'operation_id'      =>  (int) $this->operation_id,
            'operation'         =>  $this->operation->name,
            'date'              =>  Carbon::parse($this->date)->formatLocalized('%d.%m.%Y'),
            'number'            =>  $this->number,
            'debet_id'          =>  (int) $this->debet_id,
            'debet_name'        =>  $debet_name,
            'credit_id'         =>  (int) $this->credit_id,
            'credit_name'       =>  $credit_name,
            'purpose'           =>  $this->purpose,
            'debet'             =>  (float) $this->debet,
            'credit'            =>  (float) $this->credit,
            'status_code'       =>  (int) $this->status,
            'status'            =>  $status,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        // Use icon for path ??
        return [
            'meta' => [
                'breadcrumbs' => [
                    0   =>  ['name' => 'Главная', 'path' => '/'],
                    1   =>  ['name' => 'Кассовые документы', 'path' => '/cash-documents'],
                    // 2   =>  ['name' => $this->dish->name, 'path' => "/dishes/{$this->dish->id}" ],
                    // 3   =>  ['name' => 'Калькуляционные карты', 'path' => "/dishes/{$this->dish->id}/cards" , 'active' => (boolean) true],
                ],
                'links' =>  $this->links
            ],
        ];
    }
}
