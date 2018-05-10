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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listado', 'DeclaracionController@indexDec');

Route::get('/formulario', function () {
    return view('formulario');
});

Route::resource('declaraciones', 'DeclaracionController');
Route::resource('apelaciones', 'ApelacionController');
Route::resource('despartamentos', 'DepartamentoController');
Route::resource('facultades', 'FacultadController');
Route::resource('formulas', 'FormulaController');
Route::resource('roles', 'RolController');

