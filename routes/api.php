<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function() {

    Route::apiResources([
        'branches'          =>  'API\BranchController',
        'departments'       =>  'API\DepartmentController',
        'positions'         =>  'API\PositionController',
        'employees'         =>  'API\EmployeeController',
        'suppliers'         =>  'API\SupplierController',
        'income-documents'  =>  'API\IncomeDocumentController',
        'shifts'            =>  'API\ShiftController',
        'department-types'  =>  'API\DepartmentTypeController',
        'document-items'    =>  'API\DocumentItemController',
        'measures'          =>  'API\MeasureController',
        'cash-operations'   =>  'API\CashOperationController',
        'sales-revenues'    =>  'API\SalesRevenueController',
        'cashes'            =>  'API\CashController',
    ]);

    Route::get('select-dictionary/{model}', 'API\SelectDictionaryController');
    Route::get('shift-employees-on-date/{department_id}/{date}', 'API\ShiftEmployeeController@list');

});
