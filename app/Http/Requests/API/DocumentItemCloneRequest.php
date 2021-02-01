<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DocumentItemCloneRequest extends FormRequest
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
            'from'  =>  'required|exists:documents,id',     
            'to'    =>  'required|exists:documents,id',     
            'ids'   =>  'required|array|min:1',
            'ids.*' =>  'required|exists:document_items,id',
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
            'from.required' =>  "Не указан исходный документ",
            'from.exists'   =>  "Указанный исходный докумен отсутствует",
            'to.required'   =>  "Не указан документ для клонирования",
            'to.exists'     =>  "Указанный документ для клонирования отсутствует",
            'ids.required'  =>  "Не указаны спецификации для клонирование",
            'ids.*.exists'  =>  "Указанная спецификация отсутсвует"
        ];
     
    }
}
