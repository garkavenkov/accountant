<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\CashOperation;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\CashOperation\CashOperationResource;
use App\Http\Resources\API\CashOperation\CashOperationResourceCollection;

class CashOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\API\CashOperation\CashOperationResourceCollection
     */
    public function index()
    {
        $operations = CashOperation::all();

        return new CashOperationResourceCollection($operations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $operation = CashOperation::find($id);

        return new CashOperationResource($operation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
}
