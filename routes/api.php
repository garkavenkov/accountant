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
        'branches'                  =>  'API\BranchController',
        'departments'               =>  'API\DepartmentController',
        'positions'                 =>  'API\PositionController',
        'employees'                 =>  'API\EmployeeController',
        'suppliers'                 =>  'API\SupplierController',
        'income-documents'          =>  'API\IncomeDocumentController',
        'transfer-documents'        =>  'API\TransferDocumentController',
        'expense-documents'         =>  'API\ExpenseDocumentController',
        'markdown-documents'        =>  'API\MarkdownDocumentController',
        'markup-documents'          =>  'API\MarkupDocumentController',
        'writedown-documents'       =>  'API\WritedownDocumentController',
        'shifts'                    =>  'API\ShiftController',
        'department-types'          =>  'API\DepartmentTypeController',
        'document-items'            =>  'API\DocumentItemController',
        'measures'                  =>  'API\MeasureController',
        'cash-operations'           =>  'API\CashOperationController',
        'sales-revenues'            =>  'API\SalesRevenueController',
        'cash-documents'            =>  'API\CashDocumentController',
        'payments'                  =>  'API\PaymentController',
        'cashes'                    =>  'API\CashController', 
        'rest-types'                =>  'API\RestTypeController',
        'salary-types'              =>  'API\SalaryTypeController',
        'salaries'                  =>  'API\SalaryController',
        'expense-items'             =>  'API\ExpenseItemController',
        'cash-expense-documents'    =>  'API\CashExpenseDocumentController',
        'return-documents'          =>  'API\ReturnDocumentController',
        'accountabilities'          =>  'API\AccountabilityController'
    ]);

    
    Route::get('select-dictionary/{model}', 'API\SelectDictionaryController');
    
    Route::get('shift-employees-on-date/{department_id}/{date}', 'API\ShiftEmployeeController@employees');
    Route::get('employees-shifts/{employee_id}/{date?}', 'API\ShiftEmployeeController@shifts');

    Route::get('approve-cash-document/{id}',    'API\CashDocumentController@approve');
    Route::get('storno-cash-document/{id}',     'API\CashDocumentController@storno');

    Route::get('unpaid-documents/{supplier_id}',    'API\SupplierController@unpaidDocuments');

    Route::get('department-turns',  'API\DepartmentController@turns');

    Route::get('employees/{id}/current-salary/{date?}',     'API\EmployeeController@currentSalary');
    Route::get('shift-salary/{shift_id}/{employee_id?}',    'API\SalaryController@shiftsSalesRevenue');
    
    Route::post('add-employee-into-shift',                                  'API\ShiftController@addEmployee');
    Route::delete('remove-employee-from-shift/{shift_id}/{employee_id}',    'API\ShiftController@removeEmployee');
    
});
