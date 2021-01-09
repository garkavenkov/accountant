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
        'sum2',
        'user_id',
    ];

    protected static function boot() {

        parent::boot();

        static::creating(function ($model) {
            
            $model->user_id = \Auth::id();

            $number = Document::where('date', $model->date)
                                ->where('document_type_id', $model->document_type_id)
                                ->max('number');

            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }

            $model->number = $number;            
        });
    }

    public function number()
    {
        dd($this->model);
    }

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

    public function scopeMarkdown($query)
    {        
        return $query->where('operation_id', DocumentType::where('code', 'markdown')->first()->id);
    }    

    public function scopeWritedown($query)
    {        
        return $query->where('operation_id', DocumentType::where('code', 'writedown')->first()->id);
    }    

    public function scopeReturn($query)
    {        
        return $query->where('operation_id', DocumentType::where('code', 'return')->first()->id);
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
