<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CashExpenseDocumentRequest extends FormRequest
{
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
            'debet_id'      =>  'exists:cashes,id',
            'credit_id'     =>  'exists:expense_profit_items,id',
            'date'          =>  'required|date',
            'debet'         =>  'required|numeric|gt:0',
            'purpose'       =>  'required|min:3'
        ];
    }
}
