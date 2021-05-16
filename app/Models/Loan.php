<?php

namespace App\Models;

use App\Models\CashDocument;
use App\Traits\Models\PathTrait;
use App\Scopes\CashOperation\LoanScope;
use Illuminate\Database\Eloquent\Model;

class Loan extends CashDocument
{
    use PathTrait;
    
    protected $table = 'cash_documents';
   
    private $api_path = "/api/loan-documents";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LoanScope);
        
        static::creating(function ($model) {            
            
            $number = CashDocument::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
                        
            $model->number = $number;

            $operation_id = CashOperation::where('code', 'loan')->first()->id;
            $model->operation_id = $operation_id;
            $model->debet = 0;
            $model->user_id = \Auth::id();
            
        });

    }
}
