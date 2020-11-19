<?php

namespace App\Scopes\Document;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class TransferDocumentScope implements Scope
{
    // private $operation_id;

    // public function __construct()
    // {
    //     // dd(CashOperation::all());
    //     $this->operation_id = CashOperation::where('code', 'payment')->first()->id;
    // }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('document_type_id', DocumentType::where('code', 'transfer')->first()->id);
    }   
}