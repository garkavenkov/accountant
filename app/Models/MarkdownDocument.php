<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use App\Models\DocumentItem;
use App\Models\DocumentType;
use App\Models\MarkdownDocument;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\Document\MarkdownDocumentScope;

class MarkdownDocument extends Document
{
    use PathTrait;

    private $api_path="/api/markdown-documents";    

    protected static function boot() {

        parent::boot();

        static::addGlobalScope(new MarkdownDocumentScope);
        
        static::creating(function ($model) {            
            
            parent::creating($model);
                       
            $model->credit_id = 0;
            $model->credit_person_id = 0;
            $model->sum1 = 0;

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
    
}
