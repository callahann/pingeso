<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comision extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'id_rol'
    ];

    protected $dates = ['deleted_at'];

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'id_comision');
    }

    public function facultad()
    {
        return $this->hasOne(Facultad::class, 'id_comision');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_comision');
    }
}
