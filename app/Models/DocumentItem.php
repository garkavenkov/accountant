<?php

namespace App\Models;

use App\Models\Measure;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class DocumentItem extends Model
{    
    use PathTrait;
    
    protected $fillable = [
        'document_id',
        'measure_id',
        'number',
        'name',
        'quantity',
        'price',
        'price2'
    ];

    private $api_path = "/api/document-items";

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {            
            $number = DocumentItem::where('document_id', $model->document_id)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            if (!isset($model->price)) {
                $model->price = 0;
            }

            $model->number = $number;
        });
    }

    public function measure()
    {
        return $this->belongsTo(Measure::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
