<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function creationMessage() 
    {

        return response()->json('Se ha creado correctamente');
    }

    protected function updateMessage()
    {
        return response()->json('Se ha actualizado correctamente');
    }

    protected function deleteMessage()
    {
        return response()->json('Se ha borrado correctamente');
    }

    protected function notDefined()
    {
        return response()->json('Función no definida');
    }
}
