<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Declaracion extends Model
{
    protected $fillable = [
        'id',
        'id_formula',
        'id_usuario',
        'periodo',
        'docencia_comp',
        'docencia_real',
        'investigacion_comp',
        'investigacion_real',
        'asistencia_comp',
        'asistencia_real',
        'perfeccionamiento_comp',
        'perfeccionamiento_real',
        'administracion_comp',
        'administracion_real',
        'extension_comp',
        'extension_real',
        'educacion_continua_comp',
        'educacion_continua_real',
        'estado',
    ];


    protected $casts = [
        'docencia_comp'=> 'array',
        'docencia_real'=> 'array',
        'investigacion_comp'=> 'array',
        'investigacion_real'=> 'array',
        'asistencia_comp'=> 'array',
        'asistencia_real'=> 'array',
        'perfeccionamiento_comp'=> 'array',
        'perfeccionamiento_real'=> 'array',
        'administracion_comp'=> 'array',
        'administracion_real'=> 'array',
        'extension_comp'=> 'array',
        'extension_real'=> 'array',
        'educacion_continua_comp'=> 'array',
        'educacion_continua_real'=> 'array',
    ];

    public function apelaciones()
    {
        return $this->hasMany(Apelacion::class,'id_declaracion');
    }
}
