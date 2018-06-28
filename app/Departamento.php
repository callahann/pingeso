<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;
    
    protected $guarded = [
        'id_facultad'
    ];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }

    public function usuarios()
    {
        return $this->hasMany('App\User', 'id_departamento');
    }
}
