<?php

namespace App\Scopes\CashOperation;

use App\Models\CashOperation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class PaymentScope implements Scope
{
    private $operation_id;

    public function __construct()
    {
        // dd(CashOperation::all());
        $this->operation_id = CashOperation::where('code', 'payment')->first()->id;
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