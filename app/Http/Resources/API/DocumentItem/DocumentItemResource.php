<?php

namespace App\Http\Resources\API\DocumentItem;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentItemResource extends JsonResource
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
            'documentId'    =>  (int) $this->document_id,
            'id'            =>  (int) $this->id,
            'number'        =>  (int) $this->number,
            'name'          =>  $this->name,
            'measureId'     =>  (int) $this->measure_id,
            'measure'       =>  $this->measure->name,
            // 'quantity'      =>  number_format($this->quantity, 2, '.', ' '),
            // 'price'         =>  number_format($this->price, 2, '.', ' '),
            // 'price2'        =>  number_format($this->price2, 2, '.', ' '),
            // 'sum'           =>  number_format($this->quantity * $this->price, 2, '.', ' '),
            // 'sum2'          =>  number_format($this->quantity * $this->price2, 2, '.', ' '),
            // 'gain'          =>  number_format(($this->quantity * $this->price2) - ($this->quantity * $this->price),  2, '.' , ' ')
            'quantity'      =>  (float) $this->quantity,
            'purchasePrice' =>  (float) $this->price,
            'retailPrice'   =>  (float) $this->price2,
            'purchaseSum'   =>  (float) $this->quantity * $this->price,
            'retailSum'     =>  (float) $this->quantity * $this->price2,
            'gain'          =>  (float) ($this->quantity * $this->price2) - ($this->quantity * $this->price),
        ];
    }
}
