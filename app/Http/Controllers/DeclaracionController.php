<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Apelacion;
use App\Declaracion;
use App\Formula;
use App\User;

class DeclaracionController extends Controller
{   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$data = $request->validate([
            'periodo' => 'required',
        ]);*/

        $declaracion = new Declaracion($request->all());
        $declaracion->id_formula = $request->formula['id'];
        $declaracion->id_periodo = $request->periodo['id'];
        $declaracion->id_usuario = $request->usuario['id'];
        $declaracion->save();
        return $declaracion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $declaracion = Declaracion::findOrFail($id);
        $declaracion->fill($request->all());
        $declaracion->save();
        return $declaracion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Declaracion  $declaracion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $declaracion = Declaracion::findOrFail($id);
        $declaracion->delete();
        return $declaracion;
    }

    /**
     * Retorna las declaraciones que corresponden al usuario con
     * sesión activa de acuerdo a su rol. Por ejemplo, a un académico
     * retornará sus declaraciones, a un director las declaraciones
     * por aprobar, etc.
     * 
     * @return Collection 
     */
    public function allListed()
    {
        if(Auth::check()) {
            $rol = Auth::user()->rol;
            $declaraciones = [];
            switch ($rol) {
                case 0: 
                    $declaraciones = Auth::user()
                        ->declaraciones()
                        ->orderBy('created_at', 'desc')
                        ->get();
                    break;
                case 1:
                    $id_departamento = Auth::user()->id_departamento; 
                    $declaraciones = Declaracion::where('estado', 2)
                        ->whereHas('usuario', function($q) use($id_departamento) {
                            $q->where('id_departamento', $id_departamento);
                        })
                        ->get();
            }

            if(Auth::user()->id_comision != null) {
                $comision = Auth::user()->comision()->first();
                $otras = [];
                switch($comision->tipo) {
                    case 0:
                        $otras = Declaracion::has('apelacionSuperior')->get();
                        break;
                    case 1:
                        $otras = Declaracion::has('apelacionFacultad')->get();
                        break;
                    case 2:
                        $id_departamento = $comision->departamento()->first()->id;
                        $otras = Declaracion::where('estado', 3)
                            ->whereHas('periodo', function($q) use($id_departamento) {
                                $q->where('id_departamento', $id_departamento);
                                $q->where('etapa', '>=', 4);
                            })
                            ->get();
                }
                $declaraciones = $declaraciones->toBase()->merge($otras);
            }
            return $declaraciones;
        }

        return response()->json([]);
    }

    public function decline(Request $request, $id)
    {
        $request->merge(['estado' => 1]);
        return $this->update($request, $id);
    }

    public function send(Request $request, $id)
    {
        $request->merge(['estado' => 2]);
        return $this->update($request, $id);
    }

    public function approve(Request $request, $id)
    {
        $request->merge(['estado' => 3]);
        return $this->update($request, $id);
    }
}
