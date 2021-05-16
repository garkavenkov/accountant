<?php

namespace App\Scopes\CashOperation;

use App\Models\CashOperation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class LoanRepaymentScope implements Scope
{
    private $operation_id;

    public function __construct()
    {        
        $this->operation_id = CashOperation::where('code', 'loan_repayment')->first()->id;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('operation_id', $this->operation_id);
    }   
}