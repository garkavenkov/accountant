<?php

namespace App\Traits\Filters;

trait WhereTrait
{
    // protected $whereClauses = [
    //     'date'      =>  'between',
    //     'debit_id'  =>  'in',
    //     'credit_id' =>  'in',
    //     'sum1'      =>  'between',
    //     'sum2'      =>  'between'
    // ];

    protected function getWhereClause($parameters)
    {
        // dd($parameters);
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
        //  dd($whereClause);
        return $whereClause;
    }


}