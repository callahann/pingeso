<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
	<div class="container">	
		<link rel="icon" href="{{ asset('/images/logo_movil.png') }}" style="position: absolute; right: 0px">
		<div class="row">
			<h9><b>UNIVERSIDAD DE SANTIAGO DE CHILE</b></h9>
		</div>
		<div class="row">
			<h9><b>{{strtoupper($data["declaracion"]["usuario"]["departamento"]["nombre"])}}</b></h9>
		</div>
		<div class="row">
			<h9><b>DEPARTAMENTO DE {{strtoupper($data["declaracion"]["usuario"]["departamento"]["nombre"])}}</b></h9>
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
				<div class="col-md-4">
					<b>{{strtoupper($data["declaracion"]["usuario"]["apellido_paterno"])}}</b>
					<br>
					Apellido Paterno
				</div>
				<div class="col-md-4">		
					<b>{{strtoupper($data["declaracion"]["usuario"]["apellido_materno"])}}</b>
					<br>
					Apellido Materno
				</div>
				<div class="col-md-4">
					<b>{{strtoupper($data["declaracion"]["usuario"]["nombres"])}}</b>
					<br>
					Nombres
				</div>
			</div>
			<br>
			<div class="row">			
				<div class="col-md-3">
					<b>{{strtoupper($data["declaracion"]["usuario"]["departamento"]["facultad"]["nombre"])}}</b>
					<br>
					Facultad
				</div>
				<div class="col-md-3">
					<b>{{strtoupper($data["declaracion"]["usuario"]["departamento"]["nombre"])}}</b>
					<br>
					Departamento
				</div>
				<div class="col-md-3">
					<b>{{strtoupper($data["declaracion"]["usuario"]["jerarquia"]["nombre"])}}</b>
					<br>
					Jerarquia
				</div>
				<div class="col-md-3">
					<b>{{strtoupper($data["declaracion"]["usuario"]["jornada"]["nombre"])}}</b>
					<br>
					Jornada
				</div>
			</div>
		</div>
		<table class="table">
			<thead>
				
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</body>
</html>