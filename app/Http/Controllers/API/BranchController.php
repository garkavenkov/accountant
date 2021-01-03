<?php

namespace App\Http\Controllers\API;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\BranchRequest;
use App\Http\Resources\API\Branch\BranchResource;
use App\Http\Resources\API\Branch\BranchResourceCollection;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::all();

        return new BranchResourceCollection($branches);
        // return response()->json($branches);
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        $validated = $request->validated();
       
        $branch = Branch::create([
            'name'      =>  $validated['name'],
            'address'   =>  $validated['address'],
            'opened'    =>  $validated['opened'],
            'closed'    =>  $validated['closed'],
        ]);    

        return response()->json($branch, 201);
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = Branch::with('departments', 'cashes', 'employees.department', 'employees.position')->findOrFail($id);        

        // return response()->json($branch);            
        return new BranchResource($branch);
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
