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

    protected function facultad()
    {
        return $this->belongsTo(Facultad::class,'id_facultad');
    }
}
