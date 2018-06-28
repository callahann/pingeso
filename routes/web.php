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

*/

Route::get('/', 'Auth\GoogleLoginController@redirectToProvider')->name('login')->middleware(['guest']);
Route::get('/logged', 'Auth\GoogleLoginController@handleProviderCallback');
Route::get('/inicio', function() {
	return view('spa');
})->name('inicio')->middleware('auth');
Route::get('/denegado', function() {
	return view('denegado');
})->name('no-registrado');

Route::group(['middleware' => ['web', 'auth']], function (){
	Route::get('/user', function () {
		return Auth::user()->load(['departamento.facultad', 'rol']);
	});
	Route::get('/logout', function() {
		Auth::logout();
		return redirect('/');
	});
});

Route::get('/{any}', function() {
    return view('spa');
})->where('any', '.*')->middleware('auth');
