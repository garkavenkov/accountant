<?php

namespace App\Http\Requests\API;

use App\Models\Document;
use Illuminate\Validation\Factory;
use Illuminate\Foundation\Http\FormRequest;

class DocumentItemRequest extends FormRequest
{

    private $messages = [];

    public function __construct()
    {
        $this->messages = [
            'name.required'         =>  "Наименование обязательно к заполнению",
            'name.min'              =>  "Наименование должно быть минимум :min символа",
            'quantity.gt'           =>  "Количество должно быть больше 0",
            'measure_id.required'   =>  "Ед. измерения не выбрана",
            'measure_id.exists'     =>  "Ед. измерения не найдена",
            'price.gt'              =>  "Стоимость должна быть больше 0",
            'price.gt'              =>  "Новая цена должна быть меньше старой",
            'price2.gt'             =>  "Стоимость должна быть больше 0",
            'price2.gte'            =>  "Розничная стоимость должна быть больше закупочной",
        ];
    }
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
        ];
    }

     /**
     * Custom messages for validation
     *
     * @return array
     */
    public function messages()
    {
        // return [            
        //     'name.required'         =>  "Наименование обязательно к заполнению",
        //     'name.min'              =>  "Наименование должно быть минимум :min символа",
        //     'quantity.gt'           =>  "Количество должно быть больше 0",
        //     'measure_id.required'   =>  "Ед. измерения не выбрана",
        //     'measure_id.exists'     =>  "Ед. измерения не найдена",
        //     'price.gt'              =>  "Стоимость должна быть больше 0",
        //     'price.gt'              =>  "Новая цена должна быть меньше старой",
        //     'price2.gt'             =>  "Стоимость должна быть больше 0",
        //     'price2.gte'            =>  "Розничная стоимость должна быть больше закупочной",
        // ];
        return $this->messages;
    }

    public function validator(Factory $factory)
    {

        $validator = $factory->make($this->input(), $this->rules(), $this->messages(), $this->attributes());
  
        $document = Document::findOrFail($this->document_id);

        $validator->sometimes(['price', 'price2'], 'gt:0', function($input)  use($document) {                                
            return $document->type->code === 'income' || $document->type->code === 'transfer' || $document->type->code === 'markdown';
        });

        $validator->sometimes('price2', 'gt:0', function($input) use($document)  {            
            return $document->type->code === 'expense';
        });

        $validator->sometimes('price2', 'gte:price', function($input) use($document)  {            
            return $document->type->code === 'income' || $document->type->code === 'transfer';
        });        

        $validator->sometimes('price', 'gt:price2', function($input) use($document)  {            
            return $document->type->code === 'markdown';
        });        

        return $validator;
    }
}
