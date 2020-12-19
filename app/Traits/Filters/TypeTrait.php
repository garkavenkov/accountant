<?php

namespace App\Traits\Filters;

trait TypeTrait
{
    protected function getType($parameters)
    {
        $type = "";
        
        if (in_array("type", array_keys($parameters))) {
        
            $type = $parameters["type"];
            
        }        
        
        return $type;
    }

}