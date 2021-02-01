<?php

namespace App\Models;

use App\Models\ExpenseProfitItem;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExpenseProfitItem\ExpenseItemScope;

class ExpenseItem extends ExpenseProfitItem
{   
    // protected $table = "expense_profit_items";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ExpenseItemScope);

        static::creating(function ($model) {
            $type = ExpenseProfitItemType::where('code', 'expense')->first();
            $model->type_id = $type->id;            
        });
    }
}
