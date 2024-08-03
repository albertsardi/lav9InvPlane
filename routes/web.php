<?php

use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\AppController;


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

//API route
include('api.php');



//app
Route::any('/', 'App\Http\Controllers\AppController@dashboard');
Route::get('/dashboard', 'App\Http\Controllers\AppController@dashboard');

/* 
    router tuk coba2
*/
Route::prefix('test')->group(function($e) {
    // form master load
    Route::get('reportPDF', 'TestController@reportPDF');
    Route::get('koolreport/chart', 'TestController@koolreportchart');
    Route::get('koolreport/chart/pdf', 'TestController@koolreportchart_pdf');
});
