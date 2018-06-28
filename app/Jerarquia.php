<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jerarquia extends Model
{
    //

    public function usuarios()
    {
        return $this->hasMany('App\User', 'id_jerarquia');
    }
}
