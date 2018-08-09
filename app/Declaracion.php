<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Declaracion extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id',
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

    protected $appends = [
        'apelaciones',
        'formula',
        'periodo',
        'usuario'
    ];

    public function apelacion()
    {
        return $this->hasOne(Apelacion::class,'id_declaracion');
    }

    public function formula()
    {
        return $this->belongsTo(Formula::class,'id_formula');
    }

    public function periodo()
    {
        return $this->belongsTo(periodo::class,'id_periodo');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function getApelacionAttribute()
    {
        return $this->apelacion()->first();
    }

    public function getFormulaAttribute()
    {
        return $this->formula()->first();
    }

    public function getPeriodoAttribute()
    {
        return $this->periodo()->first();
    }

    public function getUsuarioAttribute()
    {
        return $this->usuario()->with('departamento.facultad')->first();
    }
}
