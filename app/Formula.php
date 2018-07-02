<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formula extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'equivalente',
        'nota_final',
        'actual',
    ];

    public function declaraciones()
    {
    	return $this->hasMany(Declaracion::class, 'id_formula');
    }
}
