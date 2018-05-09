<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'nombre_corto',
    ];
}
