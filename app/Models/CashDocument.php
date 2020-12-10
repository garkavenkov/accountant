<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Supplier;
use App\Models\CashOperation;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class CashDocument extends Model
{
    use PathTrait;
    
    private $api_path="/api/cash-documents";    
       

    protected $fillable = [
        'date',
        'operation_id',
        'number',
        'debet_id',        
        'credit_id',
        'debet',
        'credit',
        'status',
        'user_id'
    ]; 

    public function operation()
    {
        return $this->belongsTo(CashOperation::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'debet_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'credit_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'credit_id', 'id');
    }

    public function cash_credit()
    {
        return $this->belongsTo(Cash::class, 'credit_id', 'id');
    }

    public function cash_debet()
    {
        return $this->belongsTo(Cash::class, 'debet_id', 'id');
    }

    public function approve()
    {
        if ($this->status == 0) {
            
            $this->status = 1;
            return $this->save();
        }
    }
    
    public function storno()
    {
        if ($this->status == 1) {
            
            $this->status = 0;
            return $this->save();
        }
    }

    public function scopePayments($query)
    {        
        return $query->where('operation_id', CashOperation::where('code', 'payment')->first()->id);
    }

    public function scopeSalesRevenues($query)
    {
        return $query->where('operation_id', CashOperation::where('code', 'sales_revenue')->first()->id);
    }

    public function scopeSalaries($query)
    {
        return $query->where('operation_id', CashOperation::where('code', 'salary')->first()->id);
    }

    // public function document()
    // {
    //     $link_type = LinkedDocumentType::where('code', 'payment')->first();

    //     return $this->belongsToMany(IncomeDocument::class, LinkedDocument::class,  'cash_document_id', 'owner_id')->wherePivot('type_id', $link_type->id);;
    // }
}
