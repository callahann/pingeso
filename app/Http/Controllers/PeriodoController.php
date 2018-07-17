<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_dep = Auth::user()->id_departamento;
        return Periodo::where('id_departamento', $id_dep)->get();
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

        $id_dep = Auth::user()->id_departamento;
        $anterior = Periodo::where('id_departamento', $id_dep)->first();
        if ($anterior) {
            $anterior->delete();
        }
        $request->merge(['desde' => Carbon::parse($request->desde), 'hasta'=> Carbon::parse($request->hasta)]);
        
        $request->merge(['id_departamento'=>$id_dep]);
        $periodo = Periodo::create($request->all());
        $periodo->fill($request->all());
        $periodo->desde = $periodo->desde->modify('00:00:00');
        $periodo->hasta = $periodo->hasta->modify('23:59:00');
        $periodo->save();
        return $periodo;
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

        $request->merge(['desde' => Carbon::parse($request->desde), 'hasta'=> Carbon::parse($request->hasta)]);
        $periodo = Periodo::findOrFail($id);

        $periodo->fill($request->all());
        $periodo->desde = $periodo->desde->modify('00:00:00');
        $periodo->hasta = $periodo->hasta->modify('23:59:00');
        $periodo->save();

        return $periodo;
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
            'nombre' => 'required',
            'desde' => 'required|date',
            'hasta' => 'required|date',
            'etapa' => 'required|numeric',
        ];
    }
}
