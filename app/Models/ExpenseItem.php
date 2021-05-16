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

    public function category()
    {
        return $this->belongsTo(ExpenseItem::class, 'owner_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(ExpenseItem::class, 'owner_id', 'id');
    }

    public function scopeGroups($query)
    {
        return $query->where('owner_id', 0);
    }

    public function scopeCategories($query, $group_id)
    {
        return $query->where('owner_id', $group_id);
    }

    public function scopeItems($query, $category_id)
    {
        return $query->where('owner_id', $category_id);
    }

}
