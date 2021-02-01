<?php

namespace App\Models;

use App\Models\IncomeDocument;
use App\Models\LinkedDocumentType;
use Illuminate\Database\Eloquent\Model;

class LinkedDocument extends Model
{
    protected $fillable = [
        'type_id',
        'cash_document_id',
        'owner_id',
    ];

    protected static function boot()
    {
        parent::boot();

        // static::saving(function($model) {
        //     dd($model);
        // });
    }
    public function type()
    {
        return $this->hasOne(LinkedDocumentType::class, 'id', 'type_id');
    }

    public function income_document()
    {
        return $this->belongsTo(IncomeDocument::class, 'owner_id', 'id');
    }
}
