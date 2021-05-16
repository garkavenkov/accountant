<?php

namespace App\Http\Requests\API;

use Illuminate\Http\Request;
use App\Models\AccountabilityItemType;
use Illuminate\Foundation\Http\FormRequest;

class AccountabilityItemRequest extends FormRequest
{

    public function __construct(Request $request)
    {
        if ($request['type']) {
            $type = AccountabilityItemType::where('code', $request['type'])->first();
        }
        
        if($type) {
            $request->request->add(['type_id' => $type->id]);
            $request->request->remove('type');
        }
        // dd($request->request);
        // if ($request['owner_id']) {
        //     $owner_id = \explode(',', $request['owner_id']);
        //     $request->request->add(['owner_id' => $owner_id]);
        // }
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cash_document_id'  =>  'required|exists:cash_documents,id',
            'type_id'           =>  'required|exists:accountability_item_types,id',
            'amount'            =>  'required|numeric|gt:0',
            'purpose'           =>  'required|min:3',
            'owner_id'          =>  'required|exists:expense_profit_items,id'
        ];
    }

    /**
     * Custom messages for validation
     *
     * @return array
     */
    public function messages()
    {
        return [            
            'cash_document_id.required' =>  'Вы не идентификатор кассового документа',
            'cash_document_id.exists'   =>  'Кассового документ не найден',
            'type_id.required'          =>  'Вы не идентификатор типа подотчетного документа',
            'type_id.exists'            =>  'Тип подотчетного документа не найден',
            'amount.required'           =>  'Вы не указали сумму',
            'amount.gt'                 =>  'Сумма должна быть больше :gt'
        ];
    }
}
