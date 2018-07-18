<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facultad extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre'
    ];

    protected $hidden = [
        'id_comision'
    ];

    public function departamentos()
    {
        return $this->hasMany('App\Departamento', 'id_facultad');
    }

    public function comision(){
        return $this->belongsTo(Comision::class, 'id_comision');
    }

}
