<?php

namespace App\Http\Resources\API\CashDocument;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CashDocumentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'  =>  $this->collection
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
            ],
        ];
    }
}
