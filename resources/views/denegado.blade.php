<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>USACH - Declaración de Actividades Académicas</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    </head>
    <body>
        <div class="vertical-center">
            <div class="container">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading panel-title text-center">Usuario no registrado</div>
                        <div class="panel-body">
                            Usted no está autorizado/a para utilizar esta aplicación. Si se trata de un error, por favor contacte al administrador.
                        </div>
                        <div class="panel-footer">
                            <a href="/" class="btn btn-block btn-info">Reintentar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>