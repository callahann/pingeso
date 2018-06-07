<?php

namespace App\Http\Controllers;

use App\Apelacion;
use Illuminate\Http\Request;
use Validator;

class ApelacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Apelacion::paginate();
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
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }
        $fn = $request->id_declaracion . '_' . time() . $request->archivo->getClientOriginalExtension();
        $request->archivo->storeAs('apelaciones',$fn);

        $request->merge(['nombre_archivo' => $fn]);
        $apelacion = Apelacion::create($request->all());

        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Apelacion  $apelacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apelacion = Apelacion::findOrFail($id);
        return $apelacion;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Apelacion  $apelacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Apelacion $apelacion)
    {
        return $this->notDefined();
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
        $apelacion->save();

        return $this->updateMessage();
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

        return $this->deleteMessage();
    }

    protected function rules()
    {
        return [
            'id_declaracion' => 'required',
            'comentario' => 'required',
            'archivo' => 'file',
        ];
    }   
}
