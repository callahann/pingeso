<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Factor extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'diferencia',
        'factor',
    ];
    
    protected $casts = [
        'diferencia' => 'float',
        'factor' => 'float'
    ];
}
