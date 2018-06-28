<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    //
    
    public function usuarios()
    {
        return $this->hasMany('App\User', 'id_jornada');
    }
}
