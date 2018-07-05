<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Periodo::all();
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

        $anterior = Periodo::where('actual', true)->first();
        $anterior->actual = false;
        $anterior->save();

        $periodo = Periodo::create($request->all());
        return $this->creationMessage();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periodo  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $periodo = Periodo::findOrFail($id);

        $periodo->fill($data);
        $periodo->save();

        return $this->updateMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periodo  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $periodo = Periodo::findOrFail($id);
        $periodo->delete();

        return $this->deleteMessage();
    }

    protected function rules()
    {
        return [
            'desde' => 'required|date',
            'hasta' => 'required|date',
            'etapa' => 'required|numeric',
        ];
    }
}
