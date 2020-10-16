<?php

namespace App\Models;

use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class CashOperation extends Model
{
    use PathTrait;

    private $api_path="/api/cash-operations";
}
