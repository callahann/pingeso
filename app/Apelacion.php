<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apelacion extends Model
{
    protected $fillable = [
        'id_declaracion',
        'comentario',
        'nombre_archivo',
    ];

    public function declaracion()
    {
        return $this->belongsTo(Apelacion::class,'id_declaracion');
    }
}
