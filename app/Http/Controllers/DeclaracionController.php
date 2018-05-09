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
            'docencia_comp' => 'required',
            'investigacion_comp' => 'required',
            'asistencia_comp' => 'required',
            'perfeccionamiento_comp' => 'required',
            'administracion_comp' => 'required',
            'extension_comp' => 'required',
            'educacion_continua_comp' => 'required',
        ]);

        $data->merge(['id_usuario' => Auth::user()->id]);

        $declaracion = Declaracion::create($data);

        return response()->json(['Creación Correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function show(Declaracion $declaracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function edit(Declaracion $declaracion)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Declaracion $declaracion)
    {
        //
    }
}
