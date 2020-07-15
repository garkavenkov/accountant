<?php

namespace App\Services;

use Carbon\Carbon;

class DocumentService 
{
    protected $whereClauses = [
        'date'      =>  'between',
        'debit_id'  =>  'in',
        'credit_id' =>  'in',
        'sum1'      =>  'between',
        'sum2'      =>  'between'
    ];

    public function get($model, $parameters = [])
    {
        if (!array_key_exists('date', $parameters)) {
            $parameters['date'] = Carbon::now()->toDateString();            
            // $parameters['date'] = "2020-06-25,2020-07-02";
        }        
        
        $where = $this->getWhereClause($parameters);
        $relationships = $this->getRelationships($parameters);
        $per_page = $this->perPage($parameters);
        // $data = $model::with($relationships)->whereRaw($where)->get();
        $data = $model::with($relationships)->whereRaw($where);
        if ($per_page > 0) {
            $data = $data->paginate($per_page)->appends(request()->query());
        } else {
            $data = $data->get();
        }
        
        return $data;
        
    }

    protected function getWhereClause($parameters)
    {
        $whereClause = "";

        foreach ($this->whereClauses as $prop => $method) {

            if (in_array($prop, array_keys($parameters))) {
                // $clauses[$prop] = $parameters[$prop];
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
        // dd($whereClause);
        return $whereClause;
    }

    protected function getRelationships($parameters)
    {
        $relationships = [];
        if (array_key_exists('with', $parameters)) {
            $relationships = explode(',', $parameters['with']);
        }
        return $relationships;
    }

    protected function perPage($parameters)
    {
        $per_page = 0;

        if (array_key_exists('per_page', $parameters)) {
            $per_page = $parameters['per_page'];
        }
        return $per_page;
    }
}