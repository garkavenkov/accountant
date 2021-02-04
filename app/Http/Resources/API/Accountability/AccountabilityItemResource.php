<?php

namespace App\Http\Resources\API\Accountability;

use App\Models\IncomeDocument;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountabilityItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $owner = '';
        
        switch ($this->type->code) {
            case 'income':
                $document = IncomeDocument::findOrFail($this->owner_id);
                $owner = $document->department->name;
                break;
            
            default:
                # code...
                break;
        }
        return [
            'id'                =>  (int)   $this->id,
            'cashDocumentId'    =>  (int)   $this->cash_document_id,
            'typeId'            =>  (int)   $this->type_id,
            'typeCode'          =>  $this->type->code,
            'typeName'          =>  $this->type->name,            
            'ownerId'           =>  (int)   $this->owner_id,
            'owner'             =>  $owner,
            'amount'            =>  (float) $this->amount
        ];
    }
}
