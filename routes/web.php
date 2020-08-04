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
Route::get('/test',['as'=>'test','uses'=>function(){
    return view('test');
}]);
Route::get('/', 'MenuController@GetMenu')->name('index');
Route::get('/GetMenuByLang/name={name}',['as'=>'GetMenuByLang','uses'=>'MenuController@GetMenuByLang']);
Route::get('/GetSubMenu/id={id}',['as'=>'GetSubMenu','uses'=>'MenuController@GetSubMenu']);
Route::get('/DeleteMenu/Id={Id}',['as'=>'DeleteMenu','uses'=>'MenuController@DeleteMenu']);
Route::get('/CreateUpMenu',['as'=>'CreateUpMenu','uses'=>'MenuController@CreateUpMenu']);
Route::get('/CreateSubMenu/Id={Id}',['as'=>'CreateSubMenu','uses'=>'MenuController@CreateSubMenu']);
Route::post('/SaveMenu',['as'=>'SaveMenu','uses'=>'MenuController@SaveMenu']);
Route::get('/EditMenu/Name={Name}',['as'=>'EditMenu','uses'=>'MenuController@EditMenu']);
Route::post('/UpdateMenu/Id={Id}',['as'=>'UpdateMenu','uses'=>'MenuController@UpdateMenu']);
Route::get('/DeleteNews/Id={Id}',['as'=>'DeleteNews','uses'=>'PageController@DeleteNews']);
Route::get('/GetNews/{Name}',['as'=>'GetNews','uses'=>'PageController@GetNews']);
Route::get('/CreateNews/Menu={MenuName}&Page={PageName}',['as'=>'CreateNews','uses'=>'PageController@CreateNews']);
Route::get('/CreatePage/Menu={Menu}',['as'=>'CreatePage','uses'=>'PageController@CreatePage']);
Route::get('/DeletePage/Name={Name}',['as'=>'DeletePage','uses'=>'PageController@DeletePage']);
Route::post('/SavePage',['as'=>'SavePage','uses'=>'PageController@SavePage']);
Route::post('/SaveNews',['as'=>'SaveNews','uses'=>'PageController@SaveNews']);
Route::post('/SaveNews/SaveImage',['as'=>'SaveImage','uses'=>'PageController@SaveImage']);
Route::get('EditNews/id={id}',['as'=>'EditNews','uses'=>'PageController@EditNews']);
Route::post('/UpdateNews/id={id}',['as'=>'UpdateNews','uses'=>'PageController@UpdateNews']);
