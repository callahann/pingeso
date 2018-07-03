<?php

namespace App\Services;

use App\Declaracion;
use App\Periodo;
use Carbon\Carbon;

class TimerService
{
	public function run()
	{
		$periodos = Periodo::with('declaraciones')->get();

		$hoy = Carbon::now();

		foreach ($periodos as $periodo) {
			if ($periodo->hasta == $hoy) {
				$estadoSig = Periodo::where('id_departamento', $periodo->id_departamento)
									->where('estado', $periodo->estado+1)->first();
				foreach ($declaraciones as $declaracion) {
					$declaracion->estado = $periodo->estado;
					$declaracion->id_periodo = $estadoSig->id;
				}
			}
		}

	}

}