<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nombre',
    ];

    public function usuarios()
    {
        return $this->hasMany('App\User', 'id_rol');
    }
}
