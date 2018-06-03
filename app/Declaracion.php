<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Declaracion extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id',
        'id_formula',
        'id_usuario',
        'periodo',
        'item_docencia',
        'item_investigacion',
        'item_asistencia',
        'item_perfeccionamiento',
        'item_administracion',
        'item_extension',
        'item_educacion_continua',
        'estado',
    ];


    protected $casts = [
        'item_docencia'=> 'array',
        'item_investigacion'=> 'array',
        'item_asistencia'=> 'array',
        'item_perfeccionamiento'=> 'array',
        'item_administracion'=> 'array',
        'item_extension'=> 'array',
        'item_educacion_continua'=> 'array',
    ];

    public function apelaciones()
    {
        return $this->hasMany(Apelacion::class,'id_declaracion');
    }
}
