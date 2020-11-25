<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\DocumentType;
use App\Models\LinkedDocument;
use App\Traits\Models\PathTrait;
// use Illuminate\Database\Eloquent\Model;
use App\Scopes\Document\IncomeDocumentScope;

class IncomeDocument extends Document
{
    use PathTrait;
    
    private $api_path="/api/income-documents";    
    
    // protected $table = 'documents';

    // protected $fillable = [
    //     'date',  
    //     'document_type_id'     ,
    //     'number',
    //     'debet_id',        
    //     'credit_id',
    //     'credit_person_id',
    //     'sum1',
    //     'sum2',
    //     'user_id'
    // ];    

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new IncomeDocumentScope);

        static::creating(function ($model) {            
            $number = IncomeDocument::where('date', $model->date)->max('number');
            
            $document_type = DocumentType::where('code', 'income')->first();
            
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
        return $this->hasOne(Supplier::class, 'id', 'debet_id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'credit_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'credit_person_id');
    }

    // public function items()
    // {
    //     return $this->hasMany(DocumentItem::class, 'document_id', 'id');
    // }
   
    public function scopeUnpaid($query)
    {        
        return $query->where('status', 0);
    }    
   
    public function getIsPaidAttribute()
    {
        if ($this->payments->count() > 0) {
            return 1;
        } 
        
        return 0;        
    }

    public function payments()
    {
        $link_type = LinkedDocumentType::where('code', 'payment')->first();

        return $this->belongsToMany(Payment::class, LinkedDocument::class,  'owner_id', 'cash_document_id')->wherePivot('type_id', $link_type->id);
    }

    public function unpaid()
    {
        $this->status = 0;
        $this->save();
    }
}
