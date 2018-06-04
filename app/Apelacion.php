<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apelacion extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id',
        'id_declaracion',
        'comentario',
        'nombre_archivo',
    ];

    public function declaracion()
    {
        return $this->belongsTo(Apelacion::class,'id_declaracion');
    }
}
