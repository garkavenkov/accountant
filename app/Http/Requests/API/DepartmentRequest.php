<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'branch_id'             =>  'exists:branches,id',
            'department_type_id'    =>  'exists:department_types,id',
            'name'                  =>  'required|min:3',
            'description'           =>  'required|min:3',
            'opened'                =>  'required|date',
            'closed'                =>  'nullable|date|gte:opened'
        ];
    }
}
