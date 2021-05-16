<?php

namespace App\Models;

use App\Models\CashDocument;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CashOperation\LoanRepaymentScope;

class LoanRepayment extends CashDocument
{
    use PathTrait;
    
    protected $table = 'cash_documents';
   
    private $api_path = "/api/loan-repayment-documents";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LoanRepaymentScope);
        
        static::creating(function ($model) {            
            
            $number = CashDocument::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
                        
            $model->number = $number;

            $operation_id = CashOperation::where('code', 'loan_repayment')->first()->id;
            $model->operation_id = $operation_id;
            $model->credit = 0;
            $model->user_id = \Auth::id();
            
        });

    }
}
