<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comision;
use App\Departamento;
use App\Facultad;
use Validator;

class ComisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comision::all()->load('usuarios');
    }

    public function comisionDepartamento($id){
        $departamento = Departamento::findOrFail($id);
        return Comision::where('id', $departamento->id_comision)
                        ->first()
                        ->load('usuarios');
    }

    public function comisionFacultad($id){
        $facultad = Facultad::findOrFail($id);
        return Comision::where('id', $facultad->id_comision)
                        ->first()
                        ->load('usuarios');
    }

    public function comisionSuperior(){
        return Comision::where('nombre', 'Comisión Superior')
                        ->first()
                        ->load('usuarios');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->notDefined();
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
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $comision = Comision::create($request->all());

        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comision::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), $this->rules());
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $comision = Comision::findOrFail($id);
        $comision->fill($request->all());
        $comision->save();

        return $comision;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comision = Comision::findOrFail($id);
        $comision->delete();

        return $this->deleteMessaje();
    }

    protected function rules(){
    }
}
