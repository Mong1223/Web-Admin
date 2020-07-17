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
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'MenuController@GetMenu');
Route::get('/test',['as'=>'test','uses'=>function(){
    return view('test');
}]);
Route::get('/GetNews/{Name}',['as'=>'GetNews','uses'=>'MenuController@GetNews']);
Route::get('/CreateNews/{Name}',['as'=>'CreateNews','uses'=>'MenuController@CreateNews']);
Route::post('/SaveNews',['as'=>'SaveNews','uses'=>'MenuController@SaveNews']);
Route::post('/SaveNews/SaveImage',['as'=>'SaveImage','uses'=>'MenuController@SaveImage']);
