<?php

namespace App\Models;

use App\Models\ProfitItem;
use App\Models\CashDocument;
use App\Models\CashOperation;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CashOperation\ProfitScope;

class CashProfitDocument extends CashDocument
{
    use PathTrait;
    
    private $api_path="/api/cash-profit-documents";    

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ProfitScope);
        
        static::creating(function ($model) {            
           
            $number = CashDocument::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            
            $model->number = $number;
            $model->debet = 0;

            $operation_id = CashOperation::where('code', 'profit')->first()->id;
            
            $model->operation_id = $operation_id;
            
            $model->user_id = \Auth::id();            
        });     

    }
  
}
