<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<style type="text/css">
	    div.page
	    {
	        page-break-after: always;
	        page-break-inside: avoid;
	    }
	</style>
</head>
<body>
	<div class="container page">	
		<img src="{{ asset('/images/logo_movil.png') }}" style="position: absolute; right: 0px">
		<div class="row">
			<h9><b>UNIVERSIDAD DE SANTIAGO DE CHILE</b></h9>
		</div>
		<div class="row">
			<h9><b>{{mb_strtoupper($data["declaracion"]["usuario"]["departamento"]["facultad"]["nombre"])}}</b></h9>
		</div>
		<div class="row">
			<h9><b>DEPARTAMENTO DE {{mb_strtoupper($data["declaracion"]["usuario"]["departamento"]["nombre"])}}</b></h9>
		</div>
		<br>
		<div class="row">
			<center><h8><b>DECLARACIÓN DE COMPROMISOS ACADÉMICOS</b></h8></center>
		</div>
		<div class="row">
			<center><h8><b>ACADÉMICOS CUERPO REGULAR</b></h8></center>
		</div>
		<div class="row">
			<center><h8><b>AÑO {{\Carbon\Carbon::now()->year}}</b></h8></center>
		</div>
		I. Antecedentes Personales
		<div class="container-fluid" style="border: 1px solid #000 !important; padding: 5px">
			<div class="row">	
				<div class="col-xs-4">
					<b>{{mb_strtoupper($data["declaracion"]["usuario"]["apellido_paterno"])}}</b>
					<br>
					Apellido Paterno
				</div>
				<div class="col-xs-4">		
					<b>{{mb_strtoupper($data["declaracion"]["usuario"]["apellido_materno"])}}</b>
					<br>
					Apellido Materno
				</div>
				<div class="col-xs-4">
					<b>{{mb_strtoupper($data["declaracion"]["usuario"]["nombres"])}}</b>
					<br>
					Nombres
				</div>
			</div>
			<br>
			<div class="row">			
				<div class="col-xs-3">
					<b>{{mb_strtoupper($data["declaracion"]["usuario"]["departamento"]["facultad"]["nombre"])}}</b>
					<br>
					Facultad
				</div>
				<div class="col-xs-3">
					<b>{{mb_strtoupper($data["declaracion"]["usuario"]["departamento"]["nombre"])}}</b>
					<br>
					Departamento
				</div>
				<div class="col-xs-3">
					<b>{{mb_strtoupper($data["declaracion"]["usuario"]["jerarquia"]["nombre"])}}</b>
					<br>
					Jerarquia
				</div>
				<div class="col-xs-3">
					<b>{{mb_strtoupper($data["declaracion"]["usuario"]["jornada"]["nombre"])}}</b>
					<br>
					Jornada
				</div>
			</div>
		</div>
		<table class="table table-bordered" style="padding-bottom: 0px">
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th rowspan="2"><center>HORAS EQ. SEMANALES REALIZADAS</center></th>
					<th>RESERVADO COMISION</th>
				</tr>
				<tr>
					<th>RESUMEN POR ITEM</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>CALIFICACION PARCIAL</th>
				</tr>
				@if($data["declaracion"]["resumenes"])
				@foreach ($data["declaracion"]["resumenes"] as $elemento)
				<tr>
					@if($elemento["comprometido"]["horasSemana"] > 0 || $elemento["comprometido"]["horasAnio"] > 0 || $elemento["realizado"]["horasSemana"] > 0 || $elemento["realizado"]["horasAnio"] > 0)
					<td>
						@switch($loop->index)
						    @case(0)
						        DOCENCIA
						        @break
						    @case(1)
						        INVESTIGACIÓN Y DESARROLLO
						        @break
						    @case(2)
						        ADMINISTRACIÓN ACADEMICA
						        @break
						    @case(3)
						        ASISTENCIA TÉCNICA
						        @break
						    @case(4)
						        PERFECCIONAMIENTO
						        @break
						    @case(5)
						        EXTENSION
						        @break
						    @case(6)
						        EDUCACIÓN CONTINUA
						        @break    
						    @default
						        No definido ....
						@endswitch
					</td>
					<td>
						{{$elemento["comprometido"]["horasSemana"]}}
					</td>
					<td>
						{{$elemento["comprometido"]["horasAnio"]}}
					</td>
					<td>
						{{$elemento["realizado"]["horasSemana"]}}
					</td>
					<td>
						{{$elemento["realizado"]["horasAnio"]}}
					</td>
					<td>
						{{$elemento["realizado"]["equivalente"]}}
					</td>
					<td>
						@switch($loop->index)
						    @case(0)
						        {{$data["declaracion"]["item_docencia"]["calificacion"]}}
						        @break
						    @case(1)
						        {{$data["declaracion"]["item_investigacion"]["calificacion"]}}
						        @break
						    @case(2)
						        {{$data["declaracion"]["item_asistencia"]["calificacion"]}}
						        @break
						    @case(3)
						        {{$data["declaracion"]["item_perfeccionamiento"]["calificacion"]}}
						        @break
						    @case(4)
						        {{$data["declaracion"]["item_administracion"]["calificacion"]}}
						        @break
						    @case(5)
						        {{$data["declaracion"]["item_extension"]["calificacion"]}}
						        @break
						    @case(6)
						        {{$data["declaracion"]["item_educacion_continua"]["calificacion"]}}
						        @break    
						    @default
						        No definido ....
						@endswitch
					</td>
					@endif
				</tr>
				@endforeach
				@endif
				<tr>
					<th colspan=6></th>
					<th>CALIFICACION FINAL</th>
				</tr>
				<tr>
					<th></th>
					<th>Semanales</th>
					<th>Anuales</th>
					<th>Semanales</th>
					<th>Anuales</th>
					<th rowspan="2"><center> Semanales Realizadas </center></th>
					@if($data["declaracion"]["calificacion_final"]>0)
					<th>{{$data["declaracion"]["calificacion_final"]}}</th>
					@else
					<th></th>
					@endif
				</tr>
				<tr>
					<td><b>HORAS CRONOLOGICAS PROMEDIO ANUAL</b></td>
					<td>{{round($data["declaracion"]["totales"]["comprometido"]["semanal"]/$data["cantidad"],1)}}</td>
					<td>{{round($data["declaracion"]["totales"]["comprometido"]["anual"]/$data["cantidad"],1)}}</td>
					<td>{{round($data["declaracion"]["totales"]["realizado"]["semanal"]/$data["cantidad"],1)}}</td>
					<td>{{round($data["declaracion"]["totales"]["realizado"]["anual"]/$data["cantidad"],1)}}</td>
					<td><b>RANGO<b></td>
				</tr>
				<tr>
					<td><b>HORAS SEMANALES EQUIVALENTES</b></td>
					<td colspan="2">{{$data["declaracion"]["totales"]["comprometido"]["equivalente"]}}</td>
					<td colspan="2">{{$data["declaracion"]["totales"]["realizado"]["equivalente"]}}</td>
					<td></td>
					@if($data["declaracion"]["calificacion_final"])
					<td>{{$data["rango"]["leyenda"]}}</td>
					@else
					<td></td>
					@endif
				</tr>
		</table>
		<br>
		<div class="col-xs-6">
			<hr style="border: 1px solid #000">
			<b><center>
				{{mb_strtoupper($data["declaracion"]["usuario"]["apellido_paterno"])}} {{mb_strtoupper($data["declaracion"]["usuario"]["apellido_materno"])}}
				{{mb_strtoupper($data["declaracion"]["usuario"]["nombres"])}}
			</center></b>
			<b><center>{{mb_strtoupper($data["declaracion"]["usuario"]["jerarquia"]["nombre"])}}</center></b>
		</div>
		<div class="col-xs-6">
			<hr style="border: 1px solid #000">
			<b><center>
			{{mb_strtoupper($data["director"]["apellido_paterno"])}} {{mb_strtoupper($data["director"]["apellido_materno"])}}
			{{mb_strtoupper($data["director"]["nombres"])}}
			</center></b>
			<b><center>{{"DIRECTOR DE DEPARTAMENTO"}}</center></b>
		</div>
	</div>
	<div class="container page">
		II Descripción por Item
		<table class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th colspan="4">PRIMER SEMESTRE</th>
					<th colspan="4">SEGUNDO SEMESTRE</th>
					<th rowspan="3">OBSERVACIONES</th>
				</tr>
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
				</tr>
				<tr>
					<th>DOCENCIA</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data["declaracion"]["item_docencia"]["actividades"] as $elemento)
					<tr>
						<td>
							{{$elemento["descripcion"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemestre"]}}
						</td>
						@if(isset($elemento["observaciones"]))
						<td>
							{{$elemento["observaciones"]["academico"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th colspan="4">PRIMER SEMESTRE</th>
					<th colspan="4">SEGUNDO SEMESTRE</th>
					<th rowspan="3">OBSERVACIONES</th>
				</tr>
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
				</tr>
				<tr>
					<th>INVESTIGACION Y DESARROLLO</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data["declaracion"]["item_investigacion"]["actividades"] as $elemento)
					<tr>
						<td>
							{{$elemento["descripcion"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemestre"]}}
						</td>
						@if(isset($elemento["observaciones"]))
						<td>
							{{$elemento["observaciones"]["academico"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th colspan="4">PRIMER SEMESTRE</th>
					<th colspan="4">SEGUNDO SEMESTRE</th>
					<th rowspan="3">OBSERVACIONES</th>
				</tr>
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
				</tr>
				<tr>
					<th>ADMINISTRACION ACADEMICA</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data["declaracion"]["item_administracion"]["actividades"] as $elemento)
					<tr>
						<td>
							{{$elemento["descripcion"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemestre"]}}
						</td>
						@if(isset($elemento["observaciones"]))
						<td>
							{{$elemento["observaciones"]["academico"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="container page">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th colspan="4">PRIMER SEMESTRE</th>
					<th colspan="4">SEGUNDO SEMESTRE</th>
					<th rowspan="3">OBSERVACIONES</th>
				</tr>
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
				</tr>
				<tr>
					<th>ASISTENCIA TECNICA</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data["declaracion"]["item_asistencia"]["actividades"] as $elemento)
					<tr>
						<td>
							{{$elemento["descripcion"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemestre"]}}
						</td>
						@if(isset($elemento["observaciones"]))
						<td>
							{{$elemento["observaciones"]["academico"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th colspan="4">PRIMER SEMESTRE</th>
					<th colspan="4">SEGUNDO SEMESTRE</th>
					<th rowspan="3">OBSERVACIONES</th>
				</tr>
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
				</tr>
				<tr>
					<th>PERFECCIONAMIENTO</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data["declaracion"]["item_perfeccionamiento"]["actividades"] as $elemento)
					<tr>
						<td>
							{{$elemento["descripcion"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemestre"]}}
						</td>
						@if(isset($elemento["observaciones"]))
						<td>
							{{$elemento["observaciones"]["academico"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="container page">
		
		<table class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th colspan="4">PRIMER SEMESTRE</th>
					<th colspan="4">SEGUNDO SEMESTRE</th>
					<th rowspan="3">OBSERVACIONES</th>
				</tr>
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
				</tr>
				<tr>
					<th>EXTENSION</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data["declaracion"]["item_extension"]["actividades"] as $elemento)
					<tr>
						<td>
							{{$elemento["descripcion"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemestre"]}}
						</td>
						@if(isset($elemento["observaciones"]))
						<td>
							{{$elemento["observaciones"]["academico"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th colspan="4">PRIMER SEMESTRE</th>
					<th colspan="4">SEGUNDO SEMESTRE</th>
					<th rowspan="3">OBSERVACIONES</th>
				</tr>
				<tr>
					<th></th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
					<th colspan="2">COMPROMETIDO</th>
					<th colspan="2">REALIZADO</th>
				</tr>
				<tr>
					<th>EDUCACION CONTINUA</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
					<th>Hrs/Semana</th>
					<th>Hrs/Año</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data["declaracion"]["item_educacion_continua"]["actividades"] as $elemento)
					<tr>
						<td>
							{{$elemento["descripcion"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["primero"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["comprometido"]["segundo"]["horasSemestre"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemana"]}}
						</td>
						<td>
							{{$elemento["realizado"]["segundo"]["horasSemestre"]}}
						</td>
						@if(isset($elemento["observaciones"]))
						<td>
							{{$elemento["observaciones"]["academico"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>