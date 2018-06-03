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

        return response()->json('Se ha creado correctamente', 201);
    }

    protected function updateMessage()
    {
        return response()->json('Se ha actualizado correctamente', 200);
    }

    protected function deleteMessage()
    {
        return response()->json('Se ha borrado correctamente', 200);
    }

    protected function notDefined()
    {
        return response()->json('Función no definida', 404);
    }
}
