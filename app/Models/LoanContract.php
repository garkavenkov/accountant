<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Contract;
use App\Models\CashOperation;
use App\Traits\Models\PathTrait;
use App\Scopes\Contract\LoanScope;
use Illuminate\Database\Eloquent\Model;

class LoanContract extends Contract
{
    use PathTrait;
    
    private $api_path="/api/loans";

    protected static function boot()
    {
        parent::boot();

        static::addGLobalScope(new LoanScope);
        
        static::creating(function ($model) {
            
            $contract_type = ContractType::where('code', 'loan')->first();
            
            $model->contract_type_id = $contract_type->id;
        });
    }

    public function creditor()
    {
        return $this->belongsTo(Counterparty::class, 'counterparty_id', 'id');
    }

    public function repayments()
    {
        $operation_type = CashOperation::where('code', 'loan_repayment')->first();
        
        return $this->hasMany(CashDocument::class, 'credit_id', 'id')
                    ->where('operation_id', $operation_type->id);
    }

    public function rests()
    {
        $rest_type = RestType::where('code', 'loan')->first();

        return $this->hasMany(Rest::class, 'owner_id', 'id')->where('rest_type_id', $rest_type->id);
    }

    public function rest($date = null)
    {
        if (\is_null($date)) {
            $date = Carbon::now()->format('Y-m-d');            
        }

        // return $this->
    }
}
