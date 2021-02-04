<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\DocumentType;
use App\Models\Accountability;
use App\Models\LinkedDocument;
// use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\PathTrait;
use App\Models\AccountabilityItem;
use App\Scopes\Document\IncomeDocumentScope;

class IncomeDocument extends Document
{
    use PathTrait;
    
    private $api_path="/api/income-documents";    

    const FLAGS = [
        'firstForm' =>  1,
        'bonus'     =>  2
    ];

    const STATUS = [
        'new'               =>  0,
        'isPaid'            =>  1,
        'inAccountability'  =>  2,
    ];


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
   
    public function scopeUnpaid($query)
    {        
        return $query->where('status', 0);
    }    
   
    public function getIsPaidAttribute()
    {
        if ($this->status == 1) {
            return 1;
        }
        // if ($this->payments->count() > 0) {
        //     return 1;
        // } 
        
        return 0;        
    }

    public function getInAccountabilityAttribute()
    {
        if ($this->status == 2) {
            return 1;
        }

        return 0;        
    }


    public function payments()
    {
        $link_type = LinkedDocumentType::where('code', 'payment')->first();

        return $this->belongsToMany(Payment::class, LinkedDocument::class,  'owner_id', 'cash_document_id')->wherePivot('type_id', $link_type->id);
    }

    public function accountability()
    {
        $type = AccountabilityItemType::where('code', 'income')->first();

        return $this->hasOneThrough(Accountability::class, AccountabilityItem::class, 'owner_id', 'id', 'id', 'cash_document_id')->where('type_id', $type->id);
    }

    // public function unpaid()
    // {
    //     $this->status = 0;
    //     $this->save();
    // }

    public function getFirstFormAttribute()
    {
        $flag = self::FLAGS['firstForm'];
        
        if ( ($this->flag & $flag) == $flag) {
            return 1;
        } 
        return 0;
    }

    public function getBonusAttribute()
    {
        $flag = self::FLAGS['bonus'];      

        if ( ($this->flag & $flag ) == $flag) {
            return 1;
        } 
        return 0;
    }

    public function setFlag($flag)
    {
        $flag = self::FLAGS[$flag];
        
        if ( ($this->flag & $flag) != $flag) {
            $this->flag += $flag;
            $this->save();
            return true;
        } 
        return false;
    }
    
    public function unsetFlag($flag)
    {
        $flag = self::FLAGS[$flag];

        if ( ($this->flag & $flag) == $flag) {
            $this->flag -= $flag;
            $this->save();
            return true;
        } 
        return false;
    }

    public function setStatusIsPaid()
    {
        $this->status = 1;
        $this->save();
    }

    public function setStatus($status)
    {
        $status = self::STATUS[$status];
        
        if ( ($this->status & $status) != $status) {
            $this->status += $status;
            $this->save();
            return true;
        } 
        return false;
    }

    public function unsetStatus($status)
    {
        $status = self::STATUS[$status];
        
        if ( ($this->status & $status) == $status) {
            $this->status -= $status;
            $this->save();
            return true;
        } 
        return false;
    }
        

}
