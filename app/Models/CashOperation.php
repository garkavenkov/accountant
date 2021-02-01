<?php

namespace App\Models;

use App\Traits\Models\PathTrait;
use App\Models\CashOperationType;
use Illuminate\Database\Eloquent\Model;

class CashOperation extends Model
{
    use PathTrait;

    private $api_path="/api/cash-operations";

    protected $fillable = [
        'code',
        'name',
        'type_id'
    ];

    public function type()
    {
        return $this->belongsTo(CashOperationType::class, 'type_id', 'id');
    }
}
