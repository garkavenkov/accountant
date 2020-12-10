<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
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
            'debet_id'          =>  'exists:cashes,id',
            'credit_id'         =>  'exists:employees,id',
            'purpose'           =>  'required|min:5',
            'debet'             =>  'required|gt:0'
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
            'debet_id.exists'           =>  'Вы не выбрали кассу',
            'credit_id.exists'          =>  'Вы не выбрали сотрудника', 
            'purpose.required'          =>  'Вы не указали основание',
            'debet.required'            =>  'Вы не указали сумму',
            'debet.gt'                  =>  'Cумма должны быть больше 0'
        ];
    }
}
