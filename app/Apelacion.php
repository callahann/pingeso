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

    protected $appends = [
        'actual'
    ];

    public function declaracion()
    {
        return $this->belongsTo(Apelacion::class,'id_declaracion');
    }

    public function getActualAttribute() {
        return !$this->trashed();
    }
}
