<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facultad extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
    ];

    public function departamentos()
    {
        return $this->hasMany('App\Departamento', 'id_facultad');
    }

    public function comisionDeFacultad()
    {
    	return $this->hasOne(Comision::class, 'id_facultad');
    }
}
