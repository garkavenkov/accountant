<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Accountability;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\AccountabilityRequest;
use App\Http\Resources\API\Accountability\AccountabilityResource;
use App\Http\Resources\API\Accountability\AccountabilityResourceCollection;

class AccountabilityController extends Controller
{
    protected $documents;

    public function __construct(DocumentService $service)
    {
        $this->documents = $service;
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();
        
        // $parameters['with']         = 'items';
        
        // if (request()->input('per_page')) {
        //     $per_page = request()->input('per_page');
        // } else {
        //     $per_page = 10;
        // }
        
        $data = $this->documents->get(Accountability::class, $parameters);
        
        // return response()->json($data);
        return new AccountabilityResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountabilityRequest $request)
    {
        $validated = $request->validated();

        $document = Accountability::create($validated);

        return new AccountabilityResource($document);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doc = Accountability::with('items')->findOrFail($id);

        return new AccountabilityResource($doc);
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
        $document = Accountability::findOrFail($id);

        if ($document->delete()) {
            return response()->json(['message' => 'Document has been successfully deleted!'], 200);
        }
    }


    public function close($id)
    {
        $accountability = Accountability::findOrFail($id);        
        if ($accountability->close()) {            
            return response()->json(['message' => 'Авансовый отчет успешно закрыт'], 201);
        } 
        
    }  

    public function open($id)
    {
        $accountability = Accountability::findOrFail($id);

        if ($accountability->open()) {
            return response()->json(['message' => 'Авансовый отчет успешно открыт'], 201);
        };
    }
}
