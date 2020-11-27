<?php

namespace App\Models;

use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class RestType extends Model
{
    use PathTrait;

    private $api_path = "/api/rest-types";

    protected $fillable = [
        'code',
        'name',
        'description'
    ];
}
