<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\Filters\WhereTrait;
use App\Http\Controllers\Controller;

class SelectDictionaryController extends Controller
{
    use WhereTrait;
    
    protected $whereClauses = [
        // 'date'      =>  'between',
        'branch_id'  =>  'in',
        // 'credit_id' =>  'in',
        // 'sum1'      =>  'between',
        // 'sum2'      =>  'between'
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($model)
    {
        $parameters =  request()->input();

        $model = 'App\\Models\\' . \Str::studly(\Str::singular($model));

        if ($parameters) {
            $where = $this->getWhereClause($parameters);
            $data = $model::whereRaw($where)->get(['id', 'name']);
        } else {
            $data = $model::get(['id', 'name']);
        }

        return response()->json($data);
    }
}
