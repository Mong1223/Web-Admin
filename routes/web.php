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
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/test',['as'=>'test','uses'=>function(){
    return view('test');
}])->middleware('auth');
Route::get('/', 'MenuController@GetMenu')->name('index')->middleware('auth');
Route::get('/GetMenuByLang/lang={lang}',['as'=>'GetMenuByLang','uses'=>'MenuController@GetMenuByLang'])->middleware('auth');
Route::get('/GetSubMenu/id={id}&lang={lang}',['as'=>'GetSubMenu','uses'=>'MenuController@GetSubMenu'])->middleware('auth');
Route::get('/DeleteMenu/id={id}',['as'=>'DeleteMenu','uses'=>'MenuController@DeleteMenu'])->middleware('auth');
Route::get('/CreateUpMenu',['as'=>'CreateUpMenu','uses'=>'MenuController@CreateUpMenu'])->middleware('auth');
Route::get('/CreateSubMenu/id={id}',['as'=>'CreateSubMenu','uses'=>'MenuController@CreateSubMenu'])->middleware('auth');
Route::post('/SaveMenu',['as'=>'SaveMenu','uses'=>'MenuController@SaveMenu'])->middleware('auth');
Route::get('/EditMenu/id={id}',['as'=>'EditMenu','uses'=>'MenuController@EditMenu'])->middleware('auth');
Route::post('/UpdateMenu/id={id}',['as'=>'UpdateMenu','uses'=>'MenuController@UpdateMenu'])->middleware('auth');
Route::get('/DeleteNews/Id={Id}',['as'=>'DeleteNews','uses'=>'PageController@DeleteNews'])->middleware('auth');
Route::get('/GetNews/menu={menuid}&lang={lang}',['as'=>'GetNews','uses'=>'PageController@GetNews'])->middleware('auth');
Route::get('/CreateNews/Menu={MenuName}&Page={PageName}',['as'=>'CreateNews','uses'=>'PageController@CreateNews'])->middleware('auth');
Route::get('/CreatePage/menuid={menuid}&lang={lang}',['as'=>'CreatePage','uses'=>'PageController@CreatePage'])->middleware('auth');
Route::get('/DeletePage/Name={Name}',['as'=>'DeletePage','uses'=>'PageController@DeletePage'])->middleware('auth');
Route::post('/SavePage',['as'=>'SavePage','uses'=>'PageController@SavePage'])->middleware('auth');
Route::post('/SaveNews',['as'=>'SaveNews','uses'=>'PageController@SaveNews'])->middleware('auth');
Route::post('/SaveNews/SaveImage',['as'=>'SaveImage','uses'=>'PageController@SaveImage'])->middleware('auth');
Route::get('/EditNews/id={id}',['as'=>'EditNews','uses'=>'PageController@EditNews'])->middleware('auth');
Route::post('/UpdateNews/id={id}',['as'=>'UpdateNews','uses'=>'PageController@UpdateNews'])->middleware('auth');
Route::get('/password/reset/{token}',['as'=>'passwordform','uses'=>'UtilsController@ShowResetForm']);
Route::post('/password/update',['as'=>'passwordupdate','uses'=>'UtilsController@reset']);
Route::post('/messages/send',['as'=>'sendmessage','uses'=>'MessagesController@SendMessage'])->middleware('auth');
Route::get('/userSet','UtilsController@userTable')->name('userSet');
Route::post('/editgroup/id={id}&idg={idg}', 'UtilsController@editUserTable')->name('editgroup');
Route::post('/addnewgroup', 'UtilsController@ADDUserTable')->name('addnewgroup');
Route::get('/deletegroup/id={id}',['as'=>'deletegroup','uses'=>'UtilsController@deleteGroup']);
Route::get('/users','UsersController@getUsers')->name('users');
Route::post('/users/uploadfile',['as'=>'upload','uses'=>'UsersController@uploadFiles']);
