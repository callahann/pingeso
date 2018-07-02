<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rango extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'base',
        'tope',
        'leyenda',
        'color',
    ];
}
