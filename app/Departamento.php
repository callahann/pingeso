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

    protected function facultad()
    {
        return $this->belongsTo(Facultad::class,'id_facultad');
    }
}
