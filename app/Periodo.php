<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'desde',
        'hasta',
        'estado',
        'id_departamento',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'desde',
        'hasta'
    ];

    public function declaraciones()
    {
    	return $this->hasMany(Declaracion::class, 'id_periodo');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }
}
