<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Route::get('/{any}', function() {
    return view('spa');
})->where('any', '.*');
*/

Route::get('/', 'Auth\GoogleLoginController@redirectToProvider');
Route::get('/logged', 'Auth\GoogleLoginController@handleProviderCallback');
Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function (){
	Route::get('/user/email', function (){
		return Auth::user()->email;
	});
	Route::get('/user/name', function (){
		return Auth::user()->nombre;
	});
	Route::get('/user/lastname', function (){
		return Auth::user()->apellido;
	});
});

Route::get('/home', 'HomeController@index')->name('home');
