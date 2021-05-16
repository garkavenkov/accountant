<?php

namespace App\Models;

use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class Counterparty extends Model
{
    use PathTrait;

    private $api_path="/api/counterparties";

    protected $fillable = [
        'name',
        'full_name'
    ];
}
