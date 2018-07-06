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
            $id_rol = Auth::user()->id_rol;
            switch ($id_rol) {
                case 1: return Auth::user()
                                    ->declaraciones()
                                    ->orderBy('created_at', 'desc')
                                    ->get()
                                    ->load(['periodo' => function($q) {
                                        $q->withTrashed();
                                    }]);
                case 2:
                    $id_departamento = Auth::user()->id_departamento; 
                    return Declaracion::where('estado', 2)
                            ->has('periodo')
                            ->whereHas('usuario', function($q) use($id_departamento) {
                                $q->where('id_departamento', $id_departamento);
                            })
                            ->get();
                case 3: return Declaracion::where('estado', 3)
                            ->has('periodo')
                            ->get();
            }
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

    public function resolve(Request $request, $id)
    {
        $apelacion = Apelacion::where('id_declaracion', $id)->first();
        $apelacion->delete();

        return $this->update($request, $id);
    }
}
