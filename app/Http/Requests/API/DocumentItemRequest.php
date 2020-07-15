<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DocumentItemRequest extends FormRequest
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
            'name'          =>  'required|min:3',
            'quantity'      =>  'required|gt:0',
            'measure_id'    =>  'required|exists:measures,id',            
            'price'         =>  'required|numeric|gt:0',
            'price2'        =>  'required|numeric|gt:0|gte:price'
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
            'name.required'         =>  "Наименование обязательно к заполнению",
            'name.min'              =>  "Наименование должно быть минимум :min символа",
            'quantity.gt'           =>  "Количество должно быть больше 0",
            'measure_id.required'   =>  "Ед. измерения не выбрана",
            'measure_id.exists'     =>  "Ед. измерения не найдена",
            'price.gt'              =>  "Стоимость должно быть больше 0",
            'price2.gt'             =>  "Стоимость должна быть больше 0",
            'price2.gte'            =>  "Розничная стоимость должна быть больше закупочной",
        ];
    }
}
