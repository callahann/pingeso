<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Declaracion;

class Apelacion extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id',
        'id_declaracion',
        'comentario',
        'respuesta',
        'nombre_archivo',
    ];

    protected $casts = [
        'id_declaracion' => 'integer'
    ];

    public function declaracion()
    {
        return $this->belongsTo(Declaracion::class,'id_declaracion');
    }
}
