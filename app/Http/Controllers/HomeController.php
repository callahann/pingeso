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
        //dd($declaracion->calificacion_final);
        $rango = Rango::where([
                ['base','<=', $declaracion->calificacion_final],
                ['tope','>=', $declaracion->calificacion_final]
        ])->first();
        $director = User::where([
            ['rol', 1],
            ['id_departamento', $declaracion->usuario->departamento->id]
        ])->first()->load('jerarquia');
        $qtd = count($declaracion->item_docencia) + count($declaracion->item_investigacion) + count($declaracion->item_asistencia) + count($declaracion->item_perfeccionamiento) + count($declaracion->item_administracion) + count($declaracion->item_extension) + count($declaracion->item_educacion_continua);
        $data = [
            'declaracion' => $declaracion,
            'rango' => $rango,
            'director' => $director,
            'cantidad' => $qtd
        ];
        //dd($data["declaracion"]["resumenes"]);
        //dd($data["declaracion"]["item_docencia"]["actividades"][0]);
        //dd($data["rango"]);
        //return view('pdf.vista', compact(['data']));
        $pdf = PDF::loadView('pdf.vista', compact(['data']))
                ->setPaper('a4', 'landscape');
        //return $pdf->inline();
        return $pdf->download('resumen.pdf');
    }
}
