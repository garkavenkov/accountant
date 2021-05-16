<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class TransferDocumentRequest extends FormRequest
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
            'credit_id'         =>  'exists:departments,id|different:debet_id',
            'debet_person_id'   =>  'exists:employees,id',
            'credit_person_id'  =>  'exists:employees,id|different:debet_person_id',
            // 'credit_person_id'  =>  'different:debet_person_id',
            'sum1'              =>  'required|numeric|min:0',
            'sum2'              =>  'required|numeric|min:0',
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
            'date.required'                 =>  'Вы не указали дату',
            'debet_id.exists'               =>  'Вы не выбрали отдел',            
            'debet_person_id.exists'        =>  'Вы не выбрали сотрудника',            

            'credit_id.exists'              =>  'Вы не выбрали отдел',
            'credit_id.different'           =>  'Принимающий отдел должет быть отличным от передающего отдела',
            
            'credit_person_id.exists'       =>  'Вы не выбрали сотрудника',
            'credit_person_id.different'    =>  'Принимающий сотрудник должет быть отличным от передающего сотрудника',
            
            'sum1.min'                      =>  'Сумма должна быть больше или равна 0',
            'sum2.min'                      =>  'Сумма должна быть больше или равна 0',
            'sum2.gte'                      =>  'Принимаемая сумма должны быть больше или равна передаваемой сумме'
        ];
    }
}
