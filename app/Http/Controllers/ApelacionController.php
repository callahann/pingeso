<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Validator;
use App\Apelacion;
use App\Declaracion;

class ApelacionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('archivo')) {
            $fn = $request->id_declaracion . '_' . time() . '.' . $request->archivo->getClientOriginalExtension();
            $request->archivo->storeAs('apelaciones',$fn);
            $request->merge(['nombre_archivo' => $fn]);
        }

        $apelacion = Apelacion::create($request->all());
        $declaracion = Declaracion::find($request->id_declaracion);
        switch($request->comision) {
            case 0:
                $declaracion->id_apelacion_superior = $apelacion->id;
                break;
            case 1:
                $declaracion->id_apelacion_facultad = $apelacion->id;
                break;
            case 2:
                $declaracion->id_apelacion_departamental = $apelacion->id;
        }
        $declaracion->save();
        return $apelacion;
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Apelacion  $apelacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $apelacion = Apelacion::find($id);
        $apelacion->fill($request->all());
        $apelacion->resuelta = true;
        $apelacion->save();

        return $apelacion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Apelacion  $apelacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apelacion $apelacion)
    {
        $apelacion->delete();
        return $apelacion;
    }

    public function obtener($declaracion)
    {
        return Apelacion::where('id_declaracion', $declaracion)->get();
    }

    public function descargar(Apelacion $apelacion)
    {
        $path = storage_path('app/apelaciones/' . $apelacion->nombre_archivo);
        return response()->download($path);
    }

    protected function rules()
    {
        return [
            'id_declaracion' => 'required',
            'comentario' => 'required'
        ];
    }   
}
