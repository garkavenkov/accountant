<?php

namespace App\Models;

use App\Models\DocumentItem;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class IncomeDocument extends Model
{
    use PathTrait;
    
    protected $table = 'documents';

    protected $fillable = [
        'date',       
        'number',
        'debit_id',        
        'credit_id',
        'credit_person_id',
        'sum1',
        'sum2',
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {            
            $number = IncomeDocument::where('date', $model->date)->max('number');
            
            if (is_numeric($number)) {
                $number++;
            } else {
                $number = 1;
            }
            
            $model->number = $number;
            $model->user_id = \Auth::id();
        });
    }

    private $api_path="/api/income-documents";    

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'debit_id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'credit_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'credit_person_id');
    }

    public function items()
    {
        return $this->hasMany(DocumentItem::class, 'document_id', 'id');
    }

}
