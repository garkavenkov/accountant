<?php

namespace App\Models;

use App\Models\CashDocument;
use App\Models\IncomeDocument;
use App\Models\LinkedDocument;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CashOperation\PaymentScope;

class Payment extends Model
{
    use PathTrait;

    protected $table = 'cash_documents';

    private $api_path = "/api/payments";

    protected $fillable = [
        'date',
        'operation_id',
        'number',
        'debet_id',        
        'credit_id',
        'debet',
        'purpose',
        'status',
        'user_id'
    ];    

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PaymentScope);
        
        static::creating(function ($model) {            
            // dd($model);
            $number = CashDocument::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            
            $model->number = $number;
            $model->credit = 0;

            $operation_id = CashOperation::where('code', 'payment')->first()->id;
            
            $model->operation_id = $operation_id;
            
            $model->user_id = \Auth::id();
            // dd($model);
        });

        // static::deleting(function ($model) {
        //     dd($model->id . ' is about to deleting');
        // });

    }

    public function cash()
    {
        return $this->belongsTo(Cash::class, 'debet_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'credit_id', 'id');
    }

    public function documents()
    {
        $link_type = LinkedDocumentType::where('code', 'payment')->first();

        return $this->belongsToMany(IncomeDocument::class, LinkedDocument::class, 'cash_document_id', 'owner_id')
                    ->wherePivot('type_id', $link_type->id);
    }

    public function links()
    {
        $link_type = LinkedDocumentType::where('code', 'payment')->first();

        return $this->hasMany(LinkedDocument::class, 'cash_document_id')->where('type_id', $link_type->id);
    }
}
