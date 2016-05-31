<?php
header('P3P: CP="CAO PSA OUR"');
session_start();
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //return Redirect::to('movies/category');
	return Redirect::to('/login-admin');
}); 
Route::get('/login-admin', ['as' => 'login-admin', 'uses' => 'Movies\AdminController@index']);	
Route::get('/logout', array('uses'=>'Movies\AdminController@logout'));
Route::post('/confirm', array('uses'=>'Movies\AdminController@confirm'));


Route::get('dropdown/floor', array('uses'=>'AjaxController@dropdownfloor'));    
Route::get('dropdown/deft', array('uses'=>'AjaxController@dropdowndept')); 
Route::post('/post-admin-login', ['as' => 'post-admin-login', 'uses' => 'Movies\AdminController@confirm']);	
Route::group(['middleware' => 'App\Http\Middleware\AdminAuthentication', 'prefix' => 'movies'],  function () {
		
		Route::resource('/category', 'Movies\CategoryController');
		Route::get('/categorygrid/get', array('uses'=>'Movies\CategoryController@getGridData'));
		Route::post('/categorygrid/createdata', array('uses'=>'Movies\CategoryController@createData'));
		Route::post('/categorygrid/updatedata', array('uses'=>'Movies\CategoryController@updateData'));
		Route::get('/categorygrid/delete/{id?}', array('uses'=>'Movies\CategoryController@destroy'));
		Route::resource('/movies', 'Movies\MoviesController');
		Route::get('/moviesgrid/get', array('uses'=>'Movies\MoviesController@getGridData'));
		Route::post('/moviesgrid/createdata', array('uses'=>'Movies\MoviesController@createData'));
		Route::post('/moviesgrid/updatedata', array('uses'=>'Movies\MoviesController@updateData'));
		Route::get('/moviesgrid/delete/{id?}', array('uses'=>'Movies\MoviesController@destroy'));
		Route::get('/profile', array('uses'=>'Movies\ProfileController@getData'));
		Route::post('/profile/updatedata', array('uses'=>'Movies\ProfileController@updateData'));
		
		Route::post('/post-admin-update', ['as' => 'post-admin-update', 'uses' => 'Movies\AdminController@update']);	
		
		// file upload
		Route::any('/upload', 'UploadController@upload');
		Route::post('/uploadpicture', array('uses'=>'UploadController@uploadpicture'));		
		
});




Route::auth();

Route::get('/home', 'HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');
