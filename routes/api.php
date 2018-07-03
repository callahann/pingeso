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

Route::get('/auth', function (Request $request) {
    return $request->user();
});
Route::get('/auth/declaraciones', 'DeclaracionController@allListed');
Route::resource('apelaciones', 'ApelacionController');
Route::resource('declaraciones', 'DeclaracionController');
Route::get('/declaraciones/{declaracion}/aprobar', 'DeclaracionController@approval');
Route::get('/declaraciones/{declaracion}/apelaciones', 'ApelacionController@obtener');
Route::get('/descarga/apelacion/{apelacion}', 'ApelacionController@descargar');
Route::resource('departamentos', 'DepartamentoController');
Route::get('/descripciones', 'DescripcionController@all');
Route::get('/descripciones/{tipo}', 'DescripcionController@type');
Route::resource('factores', 'FactorController');
Route::resource('facultades', 'FacultadController');
Route::resource('formulas', 'FormulaController');
Route::resource('jornadas', 'JornadaController');
Route::resource('jerarquias', 'JerarquiaController');
Route::resource('rangos', 'RangoController');
Route::resource('roles', 'RolController');
Route::resource('usuarios', 'UserController')->except(['create', 'edit']);
