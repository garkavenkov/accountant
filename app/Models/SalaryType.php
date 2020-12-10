<?php

namespace App\Models;

use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class SalaryType extends Model
{
    use PathTrait;

    private $api_path = "/api/salary-types";

}
