<?php

namespace App\Models;

use App\Models\Document;
use App\Traits\Models\PathTrait;
use App\Scopes\Document\MarkupDocumentScope;

class MarkupDocument extends Document
{
    use PathTrait;

    private $api_path="/api/markup-documents";    

    protected static function boot() {

        parent::boot();

        static::addGlobalScope(new MarkupDocumentScope);
        
        static::creating(function ($model) {            
            
            parent::creating($model);
                       
            $model->debet_id = 0;
            $model->debet_person_id = 0;
            $model->sum1 = 0;

        });
    }

    
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'credit_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'credit_person_id');
    }
}
