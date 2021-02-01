<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Cash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Cash\CashResourceCollection;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\API\Cash\CashResourceCollection;
     */
    public function index()
    {
        $cashes = Cash::all();
        
        return new CashResourceCollection($cashes);
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function turns(Request $request)
    {
        $parameters = request()->input();
        
        if ( isset($parameters['id']) ) {
            $id = $parameters['id'];
        } else {
            // $id = 0;  
            // throw exception cash not selected
        }
        
        if ( isset($parameters['date_begin']) ) {
            $date_begin = $parameters['date_begin'];
        } else {
            $date_begin = Carbon::now()->toDateString();
        }

        if ( isset($parameters['date_end']) ) {
            // dd($parameters['date_end']);
            $date_end = $parameters['date_end'];
        } else {
            $date_end = $date_begin;
        }

        
        if ( isset($parameters['set_rest']) ) {
            $autoset_rest  = $parameters['set_rest'] ;
        } 

        $cash = Cash::findOrFail($id);
        
        $income_rest     = $cash->incomeRest($date_begin);

        if (\is_null($income_rest)) {
            return response()->json(['message' => "Отсутствует остаток на утро  '" . Carbon::parse($date_begin)->formatLocalized('%d.%m.%Y') . "'"], 422);
        }

        $debet_turns     = $cash->debetDocuments($date_begin, $date_end)->sum('debet');
        $credit_turns    = $cash->creditDocuments($date_begin, $date_end)->sum('credit');

        $outcome_rest    = $income_rest + $credit_turns - $debet_turns;

        if ($outcome_rest < 0) {
            return response()->json(['message' => "Отрицательный остаток в кассе: $outcome_rest"], 422);
        }

        $turns['date']          =   $date_begin;
        $turns['incomeRest']    =   $income_rest;
        $turns['debetTurns']    =   $debet_turns;
        $turns['creditTurns']   =   $credit_turns;
        $turns['outcomeRest']   =   $outcome_rest;

        
        
        if (isset($autoset_rest)) {
            if ($cash->setRest($date_begin, $outcome_rest)) {
                $turns['message']   =   'Кассовый день закрыт';
                // return \response()->json(['message' => 'Cash day was successfully closed'], 201);
            }
        }
        
        return $turns;
        
    }

    public function setRest(Request $request)
    {
        $cash_id = $request['owner_id'];

        $cash = Cash::findOrFail($cash_id);

        if ($cash->setRest($request['date'], $request['rest'])) {
            return response()->json(['message' => 'Остаток установлен'], 201);
        };
    }
}
