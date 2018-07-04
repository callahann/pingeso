<?php

namespace App\Http\Controllers;

use App\Jerarquia;
use Illuminate\Http\Request;

class JerarquiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Jerarquia::all();
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

        $jerarquia = Jerarquia::create($request->all());

        return $this->creationMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jerarquia  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Jerarquia::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jerarquia  $id
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
     * @param  \App\Jerarquia  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $jerarquia = Jerarquia::findOrFail($id);

        $jerarquia->fill($data);
        $jerarquia->save();

        return $this->updateMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jerarquia  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jerarquia = Jerarquia::findOrFail($id);
        $jerarquia->delete();

        return $this->deleteMessage();
    }

    protected function rules()
    {
        return [
            'nombre' => 'required'
        ];
    }
}
