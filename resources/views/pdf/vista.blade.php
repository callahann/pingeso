<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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
		<br>
		I. Antecedentes Personales
		<div class="container-fluid" style="border: 1px solid #000 !important; padding: 10px">
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
		<br>
		<table class="table table-bordered">
			<thead>
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
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<br>
		<table class="table table-bordered">
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
					<th rowspan="2">Semanales Realizadas</th>
					<th></th>
				</tr>
				<tr>
					<td><b>HORAS CRONOLOGICAS PROMEDIO ANUAL</b></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><b>RANGO<b></td>
				</tr>
				<tr>
					<td><b>HORAS SEMANALES EQUIVALENTES</b></td>
					<td colspan="2"></td>
					<td colspan="2"></td>
					<td></td>
					<td></td>
				</tr>
		</table>
		<br>

		<div class="col-xs-6">
			<hr style="border: 1px solid #000">
			<b><center>
				{{mb_strtoupper($data["declaracion"]["usuario"]["apellido_paterno"])}} {{mb_strtoupper($data["declaracion"]["usuario"]["apellido_materno"])}}
				{{mb_strtoupper($data["declaracion"]["usuario"]["nombres"])}}
			</center></b>
			<br>
			<b><center>{{mb_strtoupper($data["declaracion"]["usuario"]["jerarquia"]["nombre"])}}</center></b>
		</div>
		<div class="col-xs-6">
			<hr style="border: 1px solid #000">
			<b><center>
			{{mb_strtoupper($data["director"]["apellido_paterno"])}}{{mb_strtoupper($data["director"]["apellido_materno"])}}
			{{mb_strtoupper($data["director"]["nombres"])}}
			</center></b>
			<br>
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
							{{$elemento["observaciones"]}}
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
							{{$elemento["observaciones"]}}
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
							{{$elemento["observaciones"]}}
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
							{{$elemento["observaciones"]}}
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
							{{$elemento["observaciones"]}}
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
							{{$elemento["observaciones"]}}
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
							{{$elemento["observaciones"]}}
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>