<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\Filters\TypeTrait;
use App\Traits\Filters\WhereTrait;
use App\Traits\Filters\FieldsTrait;
use App\Http\Controllers\Controller;

class SelectDictionaryController extends Controller
{
    use WhereTrait, FieldsTrait, TypeTrait;
    
    protected $whereClauses = [
        // 'date'      =>  'between',
        'branch_id'  =>  'in',
        'owner_id'   =>  'in',
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
        // dd($parameters);
        $model = 'App\\Models\\' . \Str::studly(\Str::singular($model));
        
        // $fields = ['id', 'name'];

        $where  = $this->getWhereClause($parameters);
        $fields = $this->getFields($parameters);
        $type   = $this->getType($parameters);
        
        if ($type) {
            if ($where) {
                $data = $model::ofType($type)->whereRaw($where)->get($fields);
            } else {
                $data = $model::ofType($type)->get($fields);
            }
        } else {
            // $fields = ['id', 'full_name'];
            if ($where) {
                $data = $model::whereRaw($where)->get($fields);
            } else {
                $data = $model::get($fields);
            }
            
            // $data = $model::get()->pluck(array_values($fields));
        }

        // if ($where) {
        //     $data = $model::whereRaw($where)->get($fields);
        // } else if ($type) {
        //     $data = $model::whereRaw($where)->get($fields);
        // } else {
        //     $data = $model::get($fields);
        //     // dd(array_values($fields));
        //     // $data = $model::all()->pluck('id', 'full_name');
        // }
        // if ($parameters) {
        //     $where = $this->getWhereClause($parameters);
        //     $data = $model::whereRaw($where)->get($fields);
            
        // } else {
        //     $data = $model::get($fields);
        // }
        
        return response()->json($data);
    }
}
