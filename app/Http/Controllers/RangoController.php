<?php

namespace App\Http\Controllers;

use App\Rango;
use Illuminate\Http\Request;
use Validator;

class RangoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Rango::orderBy('base', 'asc')->get();
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

        $rango = Rango::create($request->all());

        return $rango;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rango  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Rango::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rango  $id
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
     * @param  \App\Rango  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $rango = Rango::findOrFail($id);

        $rango->fill($request->all());
        $rango->save();

        return $rango;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rango  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rango = Rango::findOrFail($id);
        $rango->delete();

        return $this->deleteMessage();
    }

    protected function rules()
    {
        return [
            'base' => 'required|numeric',
            'tope' => 'required|numeric',
            'leyenda' => 'required',
            'color' => 'required',
        ];
    }
}
