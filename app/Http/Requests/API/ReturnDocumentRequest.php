<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ReturnDocumentRequest extends FormRequest
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
            'credit_id'         =>  'exists:suppliers,id',            
            'sum1'              =>  'required|numeric|min:0',
            'sum2'              =>  'required|numeric|min:0|lt:sum1'
        ];
    }
}
