<?php

namespace App\Models;

use App\Models\Document;
use App\Models\Employee;
use App\Models\Department;
use App\Models\DocumentItem;
use App\Models\DocumentType;
use App\Models\TransferDocument;
use App\Traits\Models\PathTrait;
use App\Scopes\Document\TransferDocumentScope;

class TransferDocument extends Document
{
    use PathTrait;
    
    private $api_path="/api/transfer-documents";    
   
   
    protected static function boot()
    {
        parent::boot();

        static::addGlobalscope(new TransferDocumentScope);

        static::creating(function ($model) {            

            parent::creating($model);
            
        });
    }

    public function department_gives()
    {
        return $this->hasOne(Department::class, 'id', 'debet_id');
    }

    public function department_takes()
    {
        return $this->hasOne(Department::class, 'id', 'credit_id');
    }


    public function employee_gives()
    {
        return $this->hasOne(Employee::class, 'id', 'debet_person_id');
    }

    public function employee_takes()
    {
        return $this->hasOne(Employee::class, 'id', 'credit_person_id');
    }

    // public function items()
    // {
    //     return $this->hasMany(DocumentItem::class, 'document_id', 'id');
    // }
   
}
