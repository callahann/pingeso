<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descripcion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descripcion',
        'tipo'
    ];
    
}
