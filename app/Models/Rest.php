<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    protected $fillable = [
        'date',
        'rest_type_id',
        'owner_id',
        'rest'
    ];

    protected $table = "rests";
    
}
