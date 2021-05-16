<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\CashDocument;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function rests()
    {
        return $this->hasMany(CashRest::class, 'owner_id', 'id');
    }

    public function incomeRest($date)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date)->subDay()->toDateString();
        
        // try {
        //     $rest = CashRest::where('owner_id', $this->id)->where('date', $date)->first()->rest;
        //     return  (float) $rest;
        // } catch (\Throwable $th) {
        //     throw new \Exception("Отсутсвует остаток на дату '$date'", 1);
        // }        
        $rest = CashRest::where('owner_id', $this->id)->where('date', $date)->first();

        if ($rest) {
            return (float) $rest->rest;
        } else {
            return null;
        }
        
    }

    public function debetDocuments($date_begin, $date_end = null)
    {   
        if (is_null($date_end)) {
            $date_end = $date_begin;
        }

        $documents = CashDocument::whereBetween('date', [$date_begin, $date_end])
                        ->where('debet_id', '=', $this->id)
                        ->whereHas('operation.type', function($query) { 
                            $query->where('code', 'debet'); 
                        })
                        ->orderBy('date', 'asc')
                        ->orderBy('number', 'asc')
                        ->get();
        
        return $documents;
    }

    public function creditDocuments($date_begin, $date_end = null)
    {                   
        if (is_null($date_end)) {
            $date_end = $date_begin;
        }

        $documents = CashDocument::whereBetween('date', [$date_begin, $date_end])
                        ->where('credit_id', '=', $this->id)
                        ->whereHas('operation.type', function($query) { 
                            $query->where('code', 'credit'); 
                        })
                        ->orderBy('date', 'asc')
                        ->orderBy('number', 'asc')
                        ->get();

        return $documents;
    }

    public function setRest($date, $rest)
    {
        $rest = CashRest::updateOrCreate(
            [
                'owner_id'  =>  $this->id,
                'date'      =>  $date,
            ],
            [
                'owner_id'  =>  $this->id,
                'date'      =>  $date,
                'rest'      =>  $rest
            ]
        );

        return true;
    }

    public function turns($date)
    {
        $debetTurns     = $this->debetDocuments($date)->sum('debet');
        $creditTurns    = $this->creditDocuments($date)->sum('credit');

        
    }
}
