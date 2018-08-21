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
    return $request->user()->load('departamento.facultad');
});
Route::get('/pdf/{id}', 'HomeController@pdf');
Route::get('/auth/declaraciones', 'DeclaracionController@allListed');
Route::resource('apelaciones', 'ApelacionController');
Route::get('/apelaciones/{apelacion}/adjunto', 'ApelacionController@descargar');
Route::resource('declaraciones', 'DeclaracionController');
Route::put('/declaraciones/{declaracion}/enviar', 'DeclaracionController@send');
Route::put('/declaraciones/{declaracion}/aprobar', 'DeclaracionController@approve');
Route::put('/declaraciones/{declaracion}/revision', 'DeclaracionController@decline');
Route::put('/declaraciones/{declaracion}/resolver', 'DeclaracionController@resolve');
Route::get('/declaraciones/{declaracion}/apelaciones', 'ApelacionController@obtener');
Route::resource('departamentos', 'DepartamentoController');
Route::get('/descripciones', 'DescripcionController@all');
Route::get('/descripciones/{tipo}', 'DescripcionController@type');
Route::get('/comisiones/superior', 'ComisionController@comisionSuperior');
Route::get('/comisiones/departamento/{id}', 'ComisionController@comisionDepartamento');
Route::get('/comisiones/facultad/{id}', 'ComisionController@comisionFacultad');
Route::get('/usuarios/comision', 'UserController@indexComision');
Route::resource('factores', 'FactorController');
Route::resource('facultades', 'FacultadController');
Route::resource('formulas', 'FormulaController');
Route::resource('jornadas', 'JornadaController');
Route::resource('jerarquias', 'JerarquiaController');
Route::resource('rangos', 'RangoController');
Route::resource('roles', 'RolController');
Route::resource('periodos', 'PeriodoController');
Route::resource('comisiones', 'ComisionController');
Route::resource('rol_comisiones', 'Rol_ComisionController');
Route::resource('usuarios', 'UserController')->except(['create', 'edit']);
