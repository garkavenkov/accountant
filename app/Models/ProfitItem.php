<?php

namespace App\Models;

use App\Models\ExpenseProfitItem;
use App\Models\ExpenseProfitItemType;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExpenseProfitItem\ProfitItemScope;

class ProfitItem extends ExpenseProfitItem
{
    // protected $table = "expense_profit_items";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ProfitItemScope);

        static::creating(function ($model) {
            $type = ExpenseProfitItemType::where('code', 'profit')->first();
            $model->type_id = $type->id;            
        });
    }
}
