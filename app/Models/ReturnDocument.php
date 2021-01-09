<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use App\Models\ReturnDocument;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\Document\ReturnDocumentScope;

class ReturnDocument extends Document
{
    use PathTrait;
    
    private $api_path="/api/return-documents";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ReturnDocumentScope);

        static::creating(function ($model) {            
            $number = ReturnDocument::where('date', $model->date)->max('number');
            
            $document_type = DocumentType::where('code', 'return')->first();
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            $model->document_type_id = $document_type->id;
            
            $model->number = $number;
            $model->user_id = \Auth::id();
        });
    }
    
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'credit_id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'debet_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'debet_person_id');
    }

}
