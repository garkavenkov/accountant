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

    Route::get('transfer-documents', function() {
        return view('transfer_documents');
    });

    Route::get('expense-documents', function() {
        return view('expense_documents');
    });

    Route::get('markdown-documents', function() {
        return view('markdown_documents');
    });

    Route::get('writedown-documents', function() {
        return view('writedown_documents');
    });

    Route::get('markup-documents', function() {
        return view('markup_documents');
    });

    Route::get('shifts', function() {
        return view('shifts');
    });

    Route::get('sales-revenues', function() {
        return view('sales_revenues');
    });
    
    Route::get('cash-documents', function() {
        return view('cash_documents');
    });

    Route::get('cash-expense-documents', function() {
        return view('cash_expense_documents');
    });

    Route::get('cash-profit-documents', function() {
        return view('cash_profit_documents');
    });

    Route::get('payments', function() {
        return view('payments');
    });

    Route::get('department-turns', function() {
        return view('department_turns');
    });

    Route::get('salaries', function() {
        return view('salaries');
    });

    Route::get('return-documents', function() {
        return view('return_documents');
    });

    Route::get('accountabilities', function() {
        return view('accountabilities');
    });

    Route::get('close-cash-day', function() {
        return view('close_cash_day');
    });

    Route::get('link-payments', function() {
        return view('link_payments');
    });

    Route::get('reports', function() {
        return view('reports');
    });

    Route::get('loans', function() {
        return view('loans');
    });
});