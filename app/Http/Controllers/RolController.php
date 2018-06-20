<?php

namespace App\Http\Controllers;

use App\Rol;
use Illuminate\Http\Request;
use Validator;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Rol::paginate();
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

        $rol = Rol::create($data);

        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rol  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Rol::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rol  $id
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
     * @param  \App\Rol  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $rol = Rol::findOrFail($id);

        $rol->fill($data);
        $rol->save();

        return $this->updateMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rol  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return $this->deleteMessage();
    }

    protected function rules()
    {
        return [
            'nombre' => 'required'
        ];
    }
}
