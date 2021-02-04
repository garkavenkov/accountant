<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\CashOperation;
use App\Models\Accountability;
use App\Traits\Models\PathTrait;
use App\Models\AccountabilityItem;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CashOperation\AccountabilityScope;

class Accountability extends CashDocument
{
    use PathTrait;
    
    private $api_path="/api/accountabilities";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AccountabilityScope);
        
        static::creating(function ($model) {            
            
            $number = Accountability::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
                        
            $model->number = $number;
            $model->credit = 0;

            $operation_id = CashOperation::where('code', 'accountability')->first()->id;
            
            $model->operation_id = $operation_id;
            
            $model->user_id = \Auth::id();
        });
    }
    

    public function items()
    {
        return $this->hasMany(AccountabilityItem::class, 'cash_document_id', 'id');
    }

    public function cash()
    {
        return $this->belongsTo(Cash::class, 'debet_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'credit_id', 'id');
    }

    public function close()
    {
        if ( ($this->status & 2) != 2) {
            $this->status += 2;
            $this->save();
            return true;
        };
        return false;
    }

    public function open()
    {
        if ( ($this->status & 2) == 2) {
            $this->status -= 2;
            $this->save();
            return true;
        };
        return false;
    }
}
