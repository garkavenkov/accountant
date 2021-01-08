<?php

namespace App\Models;

use App\Models\CashDocument;
use App\Traits\Models\PathTrait;
use App\Models\CashExpenseDocument;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CashOperation\ExpenseScope;

class CashExpenseDocument extends CashDocument
{
    use PathTrait;
    
    private $api_path="/api/cash-expense-documents";    

    protected $table = 'cash_documents';

    protected $fillable = [
        'date',
        'operation_id',
        'number',
        'debet_id',        
        'credit_id',
        'debet',
        'credit',
        'purpose',
        'status',
        'user_id'
    ]; 

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ExpenseScope);
        
        static::creating(function ($model) {            
           
            $number = CashExpenseDocument::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            
            $model->number = $number;
            $model->credit = 0;

            $operation_id = CashOperation::where('code', 'expense')->first()->id;
            
            $model->operation_id = $operation_id;
            
            $model->user_id = \Auth::id();
            // dd($model);
        });     

    }

    // public function expense()
    // {
    //     return $this->belongsTo(ExpenseItem::class, 'credit_id', 'id');
    // }
}
