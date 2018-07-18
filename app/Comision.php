<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comision extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre'
    ];

    protected $hidden = [
        'id_rol'
    ];

    protected $dates = ['deleted_at'];

    public function departamentos(){
        return $this->hasMany(Departamento::class, 'id_comision');
    }

    public function facultades(){
        return $this->hasMany(Facultad::class, 'id_comision');
    }
}
