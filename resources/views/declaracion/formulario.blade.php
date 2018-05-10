@php($pagina = 'form')

@extends('layouts.usach')

@section('title')
Declaración de propuesta docente
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <ol class="breadcrumb">
            <li><a href="/declaraciones">Declaraciones</a></li>
            <li class="active">Formulario</li>
        </ol>
    </div>
    <formulario id="{{ $id }}"></formulario>
@endsection