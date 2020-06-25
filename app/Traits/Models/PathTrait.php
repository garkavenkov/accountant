<?php

namespace App\Traits\Models;

trait PathTrait 
{

    public function path()
    {
        return "{$this->api_path}/{$this->id}";  
    }

}