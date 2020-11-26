<?php

namespace App\Models;

use App\Models\Document;
use App\Traits\Models\PathTrait;
use App\Scopes\Document\WritedownDocumentScope;
// use Illuminate\Database\Eloquent\Model;

class WritedownDocument extends Document
{
    use PathTrait;
    
    private $api_path="/api/writedown-documents";    

    protected static function boot() {

        parent::boot();

        static::addGlobalScope(new WritedownDocumentScope);
        
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
