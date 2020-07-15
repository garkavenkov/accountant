<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('main');
// });

// Auth::routes();
Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () { 

    Route::get('/', function () {
        return view('main');
    });

    Route::get('branches', function() {
        return view('branches');
    });
    
    Route::get('departments/', function() {
        return view('departments');
    });

    Route::get('positions', function() {
        return view('positions');
    });

    Route::get('employees', function() {
        return view('employees');
    });

    Route::get('suppliers', function() {
        return view('suppliers');
    });

    Route::get('income-documents', function() {
        return view('income_documents');
    });

    Route::get('shifts', function() {
        return view('shifts');
    });

});