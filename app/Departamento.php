<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_facultad',
        'nombre'
    ];

    protected $hidden = [
        'id_comision'
    ];

    protected $guarded = [
        'id_facultad'
    ];

    protected $appends = [
        'periodo'
    ];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad')->withTrashed();
    }

    public function comision(){
        return $this->belongsTo(Comision::class, 'id_comision');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_departamento');
    }

    public function periodos()
    {
        return $this->hasMany(Periodo::class, 'id_departamento');
    }


    public function getPeriodoAttribute()
    {
        return $this->periodos()->first();
    }
}
