<?php

namespace App\Models;

use App\Models\CashOperation;
use App\Traits\Models\PathTrait;
use App\Scopes\CashOperation\SalesRevenueScope;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;

class SalesRevenue extends Model
{
    use PathTrait;
    
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

    private $api_path = "/api/sales-revenues";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SalesRevenueScope);
        
        static::creating(function ($model) {            
            // dd($model);
            $number = SalesRevenue::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            
            $model->number = $number;

            $operation_id = CashOperation::where('code', 'sales_revenue')->first()->id;
            // $operation_id = 1;
            $model->operation_id = $operation_id;
            
            $model->user_id = \Auth::id();
            // dd($model);
        });

    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'debet_id', 'id');
    }

    public function cash()
    {
        return $this->belongsTo(Cash::class, 'credit_id', 'id');
    }
}
