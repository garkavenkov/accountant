<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SalesRevenueRequest extends FormRequest
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
            'date'              =>  'required|date',
            'debet_id'          =>  'exists:departments,id',
            'credit_id'         =>  'exists:cashes,id',
            'credit'            =>  'required|numeric'
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
            'debet_id.exists'           =>  'Вы не выбрали отдел',
            'credit_id.exists'          =>  'Вы не выбрали кассу',            
            'credit'                    =>  'Cумма должны быть больше 0'
        ];
    }
}
