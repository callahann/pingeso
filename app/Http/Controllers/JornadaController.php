<?php

namespace App\Http\Controllers;

use App\Jornada;
use Illuminate\Http\Request;

class JornadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Jornada::all();
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

        $jornada = Jornada::create($request->all());

        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jornada  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Jornada::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jornada  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->notDefined();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jornada  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $jornada = Jornada::findOrFail($id);

        $jornada->fill($data);
        $jornada->save();

        return $this->updateMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jornada  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jornada = Jornada::findOrFail($id);
        $jornada->delete();

        return $this->deleteMessage();
    }

    protected function rules()
    {
        return [
            'nombre' => 'required',
            'horas' => 'required|numeric',
        ];
    }
}
