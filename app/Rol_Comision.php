<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol_Comision extends Model
{
    use SoftDeletes;

    protected $table = 'comision_rols';
    
    protected $fillable = [
        'nombre',
    ];

    public function comisiones()
    {
        return $this->hasMany(Comision::class, 'id_rol');
    }
}