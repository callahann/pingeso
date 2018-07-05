<?php

namespace App\Http\Controllers;

use App\Declaracion;
use App\User;
use App\Formula;
use Illuminate\Http\Request;
use Validator;
use Auth;

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
        /*$data = $request->validate([
            'periodo' => 'required',
        ]);*/

        //$data->merge(['id_usuario' => Auth::user()->id]);

        $declaracion->fill($request->all());
        $declaracion->save();

        return $this->updateMessage();
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

        return $this->deleteMessage();
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
            $id_rol = Auth::user()->id_rol;
            switch ($id_rol) {
                case 1: return Auth::user()
                            ->declaraciones()
                            ->where('estado', '<>', 1)
                            ->get();
                case 2:
                    $id_departamento = Auth::user()->id_departamento; 
                    return Declaracion::where('estado', 1)
                            ->whereHas('usuario', function($q) use($id_departamento) {
                                $q->where('id_departamento', $id_departamento);
                            })
                            ->whereHas('periodo', function($q) {
                                $q->where('actual', true);
                            })
                            ->get();
                case 3: return Declaracion::where('estado', 2)
                            ->whereHas('periodo', function($q) {
                                $q->where('actual', true);
                            })
                            ->get();
            }
        }

        return response()->json([]);
    }
}
