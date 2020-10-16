<?php

namespace App\Scopes;

use App\Models\CashOperation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class SalesRevenueScope implements Scope
{
    private $operation_id;

    public function __construct()
    {
        // dd(CashOperation::all());
        $this->operation_id = CashOperation::where('code', 'sales_revenue')->first()->id;
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