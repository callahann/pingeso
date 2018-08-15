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

    protected $hidden = [
        'id_apelacion_superior',
        'id_apelacion_facultad',
        'id_apelacion_departamental'
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
        'apelacion',
        'formula',
        'periodo',
        'usuario'
    ];

    public function apelacionSuperior()
    {
        return $this->hasOne(Apelacion::class,'id','id_apelacion_superior');
    }

    public function apelacionFacultad()
    {
        return $this->hasOne(Apelacion::class,'id','id_apelacion_facultad');
    }

    public function apelacionDepartamental()
    {
        return $this->hasOne(Apelacion::class,'id','id_apelacion_departamental');
    }

    public function formula()
    {
        return $this->belongsTo(Formula::class,'id_formula');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class,'id_periodo');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function getApelacionAttribute()
    {
        $superior = $this->apelacionSuperior()->first();
        $facultad = $this->apelacionFacultad()->first();
        $departamental = $this->apelacionDepartamental()->first();
        $apelaciones = [$superior, $facultad, $departamental];
        
        $i = 0;
        while($i < 3 && ($apelaciones[$i] == null || $apelaciones[$i]->resuelta)) $i++;
        $apelado = $i < 3;
        return [
            'apelado' => $apelado,
            'comision'=> $i,
            'apelar' => !$apelado && in_array(null, $apelaciones),
            'apelaciones' => $apelaciones
        ];
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
