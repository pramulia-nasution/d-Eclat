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


Route::get('/', 'DashboardController@index')->name('home');

Route::resource('/dataset','DatasetController');
Route::delete('/truncate','DatasetController@truncate')->name('truncate');
Route::delete('/truncate-data','DeclatController@clearData')->name('truncate.data');

Route::get('/download','DatasetController@download')->name('download');
Route::post('/import','DatasetController@import')->name('import');
Route::post('/support','DatasetController@updateSupp')->name('support.update');
Route::get('/support-get','DatasetController@getSupport')->name('support.get');
Route::get('/export-excel', 'ExportController@exportExcel')->name('export.excel');
Route::get('/export-pdf', 'ExportController@exportPdf')->name('export.pdf');

//link create TidList
Route::get('/item-set','ItemController@makeItemset')->name('item.set');
Route::get('/declat-set2','ItemController@createSimpul')->name('declat.set2');
Route::get('/declat-set3','DeclatController@makeItemset3')->name('declat.set3');
Route::get('/declat-set4','DeclatController@makeItemset4')->name('declat.set4');
Route::get('/declat-set5','DeclatController@makeItemset5')->name('declat.set5');
Route::get('/declat-set6','DeclatController@makeItemset6')->name('declat.set6');

//link view
Route::get('/declat-satuItemset','ItemController@index')->name('item.index');
Route::get('/declat-duaItemset','DeclatController@index')->name('declat.index');
Route::get('/declat-tigaItemset','DeclatController@Itemset3')->name('declat.tiga');
Route::get('/declat-empatItemset','DeclatController@Itemset4')->name('declat.empat');
Route::get('/declat-limaItemset','DeclatController@Itemset5')->name('declat.lima');
Route::get('/declat-enamItemset','DeclatController@Itemset6')->name('declat.enam');
Route::get('/declat-confidence','DeclatController@confidence')->name('declat.confidence');
Route::get('/declat-evaluation','DeclatController@evaluation')->name('declat.evaluation');

Auth::routes();