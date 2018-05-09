<?php

namespace App\Http\Controllers;

use App\Declaracion;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'docencia_comp' => 'required|json',
            'docencia_real' => 'json',
            'investigacion_comp' => 'required|json',
            'investigacion_real' => 'json',
            'asistencia_comp' => 'required|json',
            'asistencia_real' => 'json',
            'perfeccionamiento_comp' => 'required|json',
            'perfeccionamiento_real' => 'json',
            'administracion_comp' => 'required|json',
            'administracion_real' => 'json',
            'extension_comp' => 'required|json',
            'extension_real' => 'json',
            'educacion_continua_comp' => 'required|json',
            'educacion_continua_real' => 'json',
        ]);

        $data->merge(['id_usuario' => Auth::user()->id]);

        $declaracion = Declaracion::create($data);

        return $this->storeMessage();
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
            'docencia_comp' => 'required|json',
            'docencia_real' => 'required|json',
            'investigacion_comp' => 'required|json',
            'investigacion_real' => 'required|json',
            'asistencia_comp' => 'required|json',
            'asistencia_real' => 'required|json',
            'perfeccionamiento_comp' => 'required|json',
            'perfeccionamiento_real' => 'required|json',
            'administracion_comp' => 'required|json',
            'administracion_real' => 'required|json',
            'extension_comp' => 'required|json',
            'extension_real' => 'required|json',
            'educacion_continua_comp' => 'required|json',
            'educacion_continua_real' => 'required|json',
        ]);

        $data->merge(['id_usuario' => Auth::user()->id]);

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
