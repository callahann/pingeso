<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jerarquia extends Model
{
    protected $fillable = [
    	'nombre'
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_jerarquia');
    }
}
