<?php

namespace App\Models;

use App\Models\CashOperation;
use App\Models\Accountability;
use App\Traits\Models\PathTrait;
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
    
}
