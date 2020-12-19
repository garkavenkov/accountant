<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
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
            'department_id' =>  'required|exists:departments,id',
            'date_begin'    =>  'required|date',
            'date_end'      =>  'required|date|after_or_equal:date_begin'
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
            'department_id.required'    =>  'Вы не указали отдел',
            'department_id.exists'      =>  'Вы не выбрали отдел',
            'date_begin.required'       =>  'Вы не указали начальную дату смены',
            'date_begin.date'           =>  'Не верный формат даты',
            'date_end.required'         =>  'Вы не указали конечную дату смены',
            'date_end.after_or_equal'   =>  'Конечная дата должна быть после или равна начальной дате',
            // 'sum2.min'                      =>  'Сумма должна быть больше или равна 0',
        ];
    }


}
