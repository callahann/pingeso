@php($pagina = 'form')

@extends('layouts.usach')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><h4><b><center>Listado de Informes</center></b></h4></div>
              <div class="panel-body">
                  <div class="container">
                      <div class="row">
                          <div class="col-md-8">
                              <table class="table table-responsive">
                                    <tr>
                                      <th>Académico</th>
                                      <th>Fecha</th>
                                      <th>Estado</th>
                                      <th></th>
                                    </tr>
                                    
                              </table>
                          </div>
                      </div>
                  </div>  
              </div>
          </div>
      </div>
    </div>
</div>

@endsection
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>