<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Rest;
use App\Models\Shift;
use App\Models\SalesRevenue;
use App\Models\DepartmentType;
use App\Models\ExpenseDocument;
use App\Models\MarkdownDocument;
use App\Models\TransferDocument;
use App\Traits\Models\PathTrait;
use App\Models\WritedownDocument;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use PathTrait;

    private $api_path="/api/departments";

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function scopeGoods($query)
    {
        return $query->whereRaw('flag & 1 = 1');
    }

    public function scopeSales($query)
    {
        return $query->whereRaw('flag & 2 = 2');
    }

    public function scopeOfType($query, $type)
    {
        switch ($type) {
            case 'goods':
                $type = 1;
                break;
            case 'sales':
                $type = 2;
                break;
            default:
                $type = 0;
                break;
        }
        
        return $query->whereRaw("flag & {$type} = {$type}");
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function currentShift($date = null)
    {
        if (is_null($date)) {
            $date = Carbon::now()->format('Y-m-d');
        }

        return $this->shifts()->where('date_begin', '<=', $date)->where('date_end', '>=' , $date)->first();
    }

    public function type()
    {
        return $this->belongsTo(DepartmentType::class, 'department_type_id', 'id');
    }

    public function incomeRest($date, $strict = true)
    {
        
        $date = Carbon::createFromFormat('Y-m-d', $date)->subDay()->toDateString();
        
        $rest_type = RestType::where('code', 'department')->first();
        
        $rest = Rest::where('date', $date)->where(['rest_type_id' => $rest_type->id, 'owner_id' => $this->id])->first()->rest;
        
        if (is_null($rest)) {

            if ($strict) {
                return null;
            } else {
                $rest = Rest::where(['rest_type_id' => $rest_type->id, 'owner_id' => $this->id])->orderBy('date', 'desc')->first()->rest;

                if (is_null($rest)) {
                    return null;
                }
            }
        }         

        return (float) $rest; //Rest::where('date', $date)->where(['rest_type_id' => $rest_type->id, 'owner_id' => $this->id])->first()->rest;
    }

    
    public function turns($date)
    {
        $income_rest            = $this->incomeRest($date);
        $income_sum             = IncomeDocument::where('credit_id', $this->id)->where('date', $date)->get()->sum('sum2');
        $transfer_income_sum    = TransferDocument::where('credit_id', $this->id)->where('date', $date)->get()->sum('sum2');
        $markup_sum             = MarkupDocument::where('credit_id', $this->id)->where('date', $date)->get()->sum('sum2');

        $total_income           = $income_sum + $transfer_income_sum + $markup_sum;

        $sales_revenue_sum      = SalesRevenue::where('debet_id', $this->id)->where('date', $date)->get()->sum('credit');
        $transfer_outcome_sum   = TransferDocument::where('debet_id', $this->id)->where('date', $date)->get()->sum('sum1');
        $markdown_sum           = MarkdownDocument::where('debet_id', $this->id)->where('date', $date)->get()->sum('sum2');
        $writedown_sum          = WritedownDocument::where('debet_id', $this->id)->where('date', $date)->get()->sum('sum2');
        $expense_sum            = ExpenseDocument::where('debet_id', $this->id)->where('date', $date)->get()->sum('sum2');  
        
        $total_outcome          = $sales_revenue_sum + $transfer_outcome_sum + $markdown_sum + $writedown_sum + $expense_sum;

        $turns['departmentId']          =   $this->id;
        $turns['department']            =   $this->name;
        $turns['date']                  =   $date;
        $turns['incomeRest']            =   $this->incomeRest($date);

        $turns['credit']['total']       =   $total_income;
        $turns['credit']['income']      =   $income_sum;
        $turns['credit']['transfer']    =   $transfer_income_sum;
        $turns['credit']['markup']      =   $markup_sum;

        $turns['debet']['total']        =   $total_outcome;
        $turns['debet']['sales']        =   $sales_revenue_sum;
        $turns['debet']['transfer']     =   $transfer_outcome_sum;
        $turns['debet']['markdown']     =   $markdown_sum;
        $turns['debet']['writedown']    =   $writedown_sum;
        $turns['debet']['expense']      =   $expense_sum;

        $turns['outcomeRest']           =   $income_rest + $total_income - $total_outcome;

        return json_encode($turns, JSON_UNESCAPED_UNICODE);
        // return $turns;
    }
    
}
