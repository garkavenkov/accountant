<?php

namespace App\Services;

use Carbon\Carbon;
use App\Traits\Filters\WhereTrait;

class DocumentService 
{
    use WhereTrait;
    
    protected $whereClauses = [
        'date'          =>  'between',
        'operation_id'  =>  'in',
        'debet_id'      =>  'in',
        'credit_id'     =>  'in',
        'sum1'          =>  'between',
        'sum2'          =>  'between'
    ];

    public function get($model, $parameters = [])
    {
        if (!array_key_exists('date', $parameters)) {            
            $parameters['date'] = Carbon::now()->toDateString();
        }        
        
        $where = $this->getWhereClause($parameters);
        
        $relationships = $this->getRelationships($parameters);
        
        // $scopes = $this->getScopes($parameters);        
        $per_page = $this->perPage($parameters);

        // $data = $model::with($relationships)->whereRaw($where)->get();
        
        // if ($scopes) {
        //     foreach ($scopes as $scope) {
        //         $data = $model::$scope;
        //     }
        // }

        $data = $model::with($relationships)->whereRaw($where);
        // dd($model::with($relationships)->orderBy('date', 'asc')->get());
        // dd($model::all());
        
        if ($per_page > 0) {
            $data = $data->paginate($per_page)->appends(request()->query());
        } else {
            $data = $data->orderBy('date', 'asc')->orderBy('number', 'asc')->get();
        }
        // dd($data);
        return $data;
        
    }
    /*
    protected function getWhereClause($parameters)
    {
        $whereClause = "";

        foreach ($this->whereClauses as $prop => $method) {

            if (in_array($prop, array_keys($parameters))) {               
                $keys = explode(',', $parameters[$prop]);
                if (count($keys) > 1) {
                    if ($method === 'between') {
                        $where = "{$prop} between '$keys[0]' and '$keys[1]'";    
                    }
                } else {
                    $where = "{$prop}='$keys[0]'";
                }
                if ($whereClause) {
                    $whereClause = $whereClause . ' and ' . $where;
                } else {
                    $whereClause = $whereClause . $where;
                }
                
            }
        }        
        return $whereClause;
    }
    */

    protected function getRelationships($parameters)
    {
        $relationships = [];
        if (array_key_exists('with', $parameters)) {
            $relationships = explode(',', $parameters['with']);
        }
        return $relationships;
    }

    // protected function getScopes($parameters)
    // {
    //     $scopes = [];
    //     if (array_key_exists('scope', $parameters)) {
    //         $scopes = explode(',', $parameters['scope']);
    //     }
    //     return $scopes;
    // }

    protected function perPage($parameters)
    {
        $per_page = 0;

        if (array_key_exists('per_page', $parameters)) {
            $per_page = $parameters['per_page'];
        }
        return $per_page;
    }
}