<?php

namespace App\Http\Requests\API;

use App\Rules\ShiftEmployee\UniquePerShift;
use Illuminate\Foundation\Http\FormRequest;

class ShiftEmployeeRequest extends FormRequest
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
            'shift_id'      =>  'required|exists:shifts,id',
            'employee_id'   =>  ['required', 'exists:employees,id', new UniquePerShift($this->shift_id)]
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
            'shift_id.required'         =>  'Вы не указали смену',
            'shift_id.exists'           =>  'Смена с id :shift_id отсутсвует',
            
            'employee_id.required'      =>  'Вы не указали сотрудника',
            'employee_id.exists'        =>  'Сотрудник с id :employee_id отсутсвует',
        ];
    }
}
