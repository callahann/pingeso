<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Declaracion;
use App\Rango;
use App\User;
use PDF;

class HomeController extends Controller
{
    /**
     * 
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('spa');
    }

    public function pdf($id)
    {
        $declaracion = Declaracion::findOrFail($id)->load(['usuario.departamento.facultad','usuario.jornada', 'usuario.jerarquia']);
        $rangos = Rango::all();
        $director = User::with('jerarquia')->where('id_rol',2)->where('id_departamento', $declaracion->usuario->departamento->id)->first();
        $data = [
            'declaracion' => $declaracion,
            'rangos' => $rangos,
            'director' => $director,
        ];
        //dd($data["declaracion"]["item_docencia"]);
        //return view('pdf.vista', compact(['data']));
        $pdf = PDF::loadView('pdf.vista', compact(['data']))
                ->setPaper('a4', 'landscape');
        //return $pdf->inline();
        return $pdf->download('resumen.pdf');
    }
}
