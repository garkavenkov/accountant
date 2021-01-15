<?php

namespace App\Models;

use App\Models\Rest;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\Rest\DepartmentRestScope;

class DepartmentRest extends Rest
{
    protected static function boot() 
    {
        
        parent::boot();

        static::addGlobalScope(new DepartmentRestScope);

        static::creating(function($model) {

            $rest_type = RestType::where('code', 'department')->first();
            $model->rest_type_id = $rest_type->id;
        });
    }
}
