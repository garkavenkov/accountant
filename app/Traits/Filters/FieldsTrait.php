<?php

namespace App\Traits\Filters;

trait FieldsTrait
{
    protected function getFields($parameters)
    {
        $fields = ['id', 'name'];

        if (in_array("fields", array_keys($parameters))) {
        
            $fields = explode(',', $parameters["fields"]);                
            
        }        
        
        return $fields;
    }

}