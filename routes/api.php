<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('declaraciones', 'DeclaracionController');
Route::get('/declaraciones/{declaracion}/aprobar', 'DeclaracionController@approval');

Route::resource('declaraciones', 'DeclaracionController');
Route::resource('apelaciones', 'ApelacionController');
Route::resource('despartamentos', 'DepartamentoController');
Route::resource('facultades', 'FacultadController');
Route::resource('formulas', 'FormulaController');
Route::resource('roles', 'RolController');
