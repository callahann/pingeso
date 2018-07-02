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
        <div id="app">
            <app>
                <div class="vertical-center">
                    <div class="container">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="panel panel-default text-center">
                                <div class="panel-body">
                                    <h3>
                                        <i class="fas fa-circle-notch fa-spin loading"></i> 
                                        <p>Cargando...</p>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </app>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>