<?php

namespace App\Models;

use App\Models\DocumentType;
// use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    // use PathTrait;
    
    protected $table = 'documents';

    protected $fillable = [
        'date',       
        'document_type_id',
        'number',
        'debet_id',        
        'debet_person_id',
        'credit_id',
        'credit_person_id',
        'sum1',
        'sum2'
    ];

    public function scopeIncome($query)
    {        
        return $query->where('operation_id', DocumentType::where('code', 'income')->first()->id);
    }

    public function scopeTransfer($query)
    {        
        return $query->where('operation_id', DocumentType::where('code', 'transfer')->first()->id);
    }

    public function scopeExpense($query)
    {        
        return $query->where('operation_id', DocumentType::where('code', 'expense')->first()->id);
    }    

    public function items()
    {
        return $this->hasMany(DocumentItem::class, 'document_id', 'id');
    }

    public function type()
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_type_id');
    }

}
