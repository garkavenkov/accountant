<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class IncomeDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            'date'              =>  'required|date',
            'debet_id'          =>  'exists:suppliers,id',
            'credit_id'         =>  'exists:departments,id',
            'credit_person_id'  =>  'exists:employees,id',
            'sum1'              =>  'required|numeric|min:0',
            'sum2'              =>  'required|numeric|min:0|gte:sum1'
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
            'date.required'             =>  'Вы не указали дату',
            'debit_id.exists'           =>  'Вы не выбрали поставщика',            
            'credit_id.exists'          =>  'Вы не выбрали отдел',
            'credit_person_id.exists'   =>  'Вы не выбрали сотрудника',
            'sum1.min'                  =>  'Сумма должна быть больше или равна 0',
            'sum2.min'                  =>  'Сумма должна быть больше или равна 0',
            'sum2.gte'                  =>  'Розничная сумма должны быть больше или равна сумме закупки'
        ];
    }
}
