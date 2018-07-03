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

    protected $appends = [
        'departamentos'
    ];

    public function departamentos()
    {
        return $this->hasMany('App\Departamento', 'id_facultad');
    }

    public function getDepartamentosAttribute()
    {
        return $this->departamentos()->get();
    }
}
