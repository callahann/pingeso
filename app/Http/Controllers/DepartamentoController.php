<?php

namespace App\Http\Controllers;

use App\Departamento;
use Illuminate\Http\Request;
use Validator;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Departamento::all();
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

        $departamento = Departamento::create($request->all());

        return $this->creationMessage();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id));

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $departamento = Departamento::findOrFail($id);

        $departamento->fill($request->all());
        $departamento->save();

        return $this->updateMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return $this->deleteMessage();
    }

    protected function rules($id)
    {
        if($id) {
            return [
                'id_facultad' => 'required',
                'nombre' => 'required|unique:departamentos,nombre,' . $id
            ];
        }
        return [
            'id_facultad' => 'required',
            'nombre' => 'required|unique:departamentos,nombre'
        ];
    }
}
