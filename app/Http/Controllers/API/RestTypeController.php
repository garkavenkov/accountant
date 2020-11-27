<?php

namespace App\Http\Controllers\API;

use App\Models\RestType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\RestType\RestTypeResource;
use App\Http\Resources\API\RestType\RestTypeResourceCollection;

class RestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\API\RestType\RestTypeResourceCollection
     */
    public function index()
    {
        $types = RestType::all();

        return new RestTypeResourceCollection($types);
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
        $type = RestType::findOrFail($id);

        return new RestTypeResource($type);
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
