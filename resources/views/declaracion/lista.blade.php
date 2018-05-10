@php($pagina = 'form')

@extends('layouts.usach')

@section('title')
Lista declaraciones
@endsection

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                Declaraciones
                <a type="button" class="btn btn-xs btn-success pull-right" href="/declaraciones/formulario">     
                    Agregar declaración <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>
            <div class="panel-body">
                @if($declaraciones->count() == 0)
                <div class="text-center">
                    <h3>No se han ingresado nuevas declaraciones</h3>
                </div>
                @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Creada el</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($declaraciones as $declaracion)
                        <tr>
                            <td>{{ $declaracion->periodo }}</td>
                            <td>{{ $declaracion->created_at }}</td>
                            <td>
                                <a type="button" class="btn btn-xs btn-success" href="{{ route('formulario', ['declaracion' => $declaracion]) }}">     
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                </a>
                                <button type="button" class="btn btn-xs btn-danger">     
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                {{ $declaraciones->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection