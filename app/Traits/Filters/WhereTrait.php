<?php

namespace App\Traits\Filters;

trait WhereTrait
{
    protected function getWhereClause($parameters)
    {        
        $whereClause = "";
        
        foreach ($parameters as $field => $value) {
            if (in_array($field, array_keys($this->whereClauses))) {
                $method = $this->whereClauses[$field];
                $keys = \explode(',', $value);

                if (\is_array($method)) {
                    // $fields = explode(',', $method['fields']);
                    
                    $fields = array_map(function ($field) use($value) {
                        return "$field='$value'";
                    }, explode(',', $method['fields']));

                    $where = '( ' . \implode(' or ', $fields) . ' )';
                } else {

                    if (\count($keys) > 1) {
                        if ($method == 'between') {
                            $where = "$field between '$keys[0]' and '$keys[1]'";
                        }
                    } else {
                        $where = "$field = '$value'";
                    }
                }

                if ($whereClause) {
                    $whereClause = $whereClause . ' and ' . $where;
                } else {
                    $whereClause = $whereClause . $where;
                }

            }
                        
        }       
       
    //    dd($whereClause);
        return $whereClause;
    }


}