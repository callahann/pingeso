<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'id_facultad',
        'nombre',
        'codigo',
        'nombre_corto',
    ];
}
