<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use App\Models\DocumentItem;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\Document\ExpenseDocumentScope;

class ExpenseDocument extends Document
{
    use PathTrait;
    
    private $api_path="/api/expense-documents";    

    protected static function boot()
    {
        parent::boot();

        static::addGlobalscope(new ExpenseDocumentScope);

        static::creating(function ($model) {            
            
            $number = ExpenseDocument::where('date', $model->date)->max('number');
            
            $document_type = DocumentType::where('code', 'expense')->first();
            
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            $model->document_type_id = $document_type->id;            
            $model->number = $number;
            $model->credit_id = 0;
            $model->credit_person_id = 0;
            $model->sum1 = 0;
            $model->user_id = \Auth::id();
        });
    }

    
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'debet_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'debet_person_id');
    }

    // public function items()
    // {
    //     return $this->hasMany(DocumentItem::class, 'document_id', 'id');
    // }
    
}
