<?php

namespace App\Models;

use App\Models\Cash;
use App\Models\Employee;
use App\Models\CashOperation;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CashOperation\SalaryScope;

class Salary extends Model
{
    use PathTrait;
    
    protected $table = 'cash_documents';

    protected $fillable = [
        'date',
        'operation_id',
        'number',
        'debet_id',        
        'credit_id',
        'purpose',
        'debet',
        'credit',
        'status',
        'user_id'
    ];    

    private $api_path = "/api/salaries";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SalaryScope);
        
        static::creating(function ($model) {            
            
            $number = Salary::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            
            $model->number = $number;

            $operation_id = CashOperation::where('code', 'salary')->first()->id;
            
            $model->operation_id = $operation_id;
            $model->credit = 0;
            $model->user_id = \Auth::id();
            
        });

    }

    public function cash()
    {
        return $this->belongsTo(Cash::class, 'debet_id', 'id');
    }    

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'credit_id', 'id');
    }
}
