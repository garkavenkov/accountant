<?php

namespace App\Traits\Models;

trait PathTrait 
{

    public function path($url = NULL)
    {
        if ($url) {
            return "{$url}/{$this->id}";      
        }

        return "{$this->api_path}/{$this->id}";  
    }

}