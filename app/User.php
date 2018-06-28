<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id_departamento',
        'id_jerarquia',
        'id_jornada',
        'id_rol'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function departamento()
    {
        return $this->belongsTo('App\Departamento', 'id_departamento');
    }

    public function jerarquia()
    {
        return $this->belongsTo('App\Jerarquia', 'id_jerarquia');
    }

    public function jornada()
    {
        return $this->belongsTo('App\Jornada', 'id_jornada');
    }

    public function rol()
    {
        return $this->belongsTo('App\Rol', 'id_rol');
    }
}
