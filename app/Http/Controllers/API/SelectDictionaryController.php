<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelectDictionaryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($model)
    {
        $model = 'App\\Models\\' . \Str::studly(\Str::singular($model));

        $data = $model::get(['id', 'name']);

        return response()->json($data);
    }
}
