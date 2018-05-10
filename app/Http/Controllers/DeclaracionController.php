<?php

namespace App\Http\Controllers;

use App\Declaracion;
use App\User;
use App\Formula;
use Illuminate\Http\Request;

class DeclaracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Declaracion::paginate();
    }

    public function indexDec(){
        //$declaraciones = Declaracion::all();
        //$users = User::all();
        //return view('listado', compact('declaraciones','users'));
        return view('listado');
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->notDefined();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'periodo' => 'required',
            'docencia_comp' => 'required',
            'investigacion_comp' => 'required',
            'asistencia_comp' => 'required',
            'perfeccionamiento_comp' => 'required',
            'administracion_comp' => 'required',
            'extension_comp' => 'required',
            'educacion_continua_comp' => 'required',
        ]);

        /*$data->merge([
            'id_usuario' => User::first()->id,
            'id_formula' => Formula::first()->id
        ]);
        */

        $declaracion = Declaracion::create($data);

        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function show(Declaracion $declaracion)
    {
        return $declaracion;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function edit(Declaracion $declaracion)
    {
        return $this->notDefined();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Declaracion $declaracion)
    {
        $data = $request->validate([
            'periodo' => 'required',
            'docencia_comp' => 'required',
            'docencia_real' => 'required',
            'investigacion_comp' => 'required',
            'investigacion_real' => 'required',
            'asistencia_comp' => 'required',
            'asistencia_real' => 'required',
            'perfeccionamiento_comp' => 'required',
            'perfeccionamiento_real' => 'required',
            'administracion_comp' => 'required',
            'administracion_real' => 'required',
            'extension_comp' => 'required',
            'extension_real' => 'required',
            'educacion_continua_comp' => 'required',
            'educacion_continua_real' => 'required',
        ]);

        //$data->merge(['id_usuario' => Auth::user()->id]);

        $declaracion->fill($data);
        $declaracion->save();

        return $this->updateMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Declaracion $declaracion)
    {
        $declaracion->delete();

        return $this->deleteMessage();
    }
}
