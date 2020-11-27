<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MarkupDocumentRequest extends FormRequest
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
            'debet_person_id'   =>  'exists:employees,id',
            'sum2'              =>  'required|numeric|min:0',
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
            'sum2.min'                      =>  'Сумма должна быть больше или равна 0',
        ];
    }
}
