<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jornada extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    	'nombre',
    	'horas'
    ];
    
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_jornada');
    }
}
