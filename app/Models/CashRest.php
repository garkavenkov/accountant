<?php

namespace App\Models;

use App\Models\RestType;
use App\Scopes\Rest\CashRestScope;
use Illuminate\Database\Eloquent\Model;

class CashRest extends Rest
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CashRestScope);

        static::creating(function($model) {
            $rest_type = RestType::where('code', 'cash')->first();
            $model->rest_type_id = $rest_type->id;
        });
    }
}
