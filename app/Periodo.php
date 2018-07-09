<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Periodo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'desde',
        'hasta',
        'etapa',
        'id_departamento',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'desde',
        'hasta'
    ];

    protected $appends = [
        'actual'
    ];

    public function declaraciones()
    {
    	return $this->hasMany(Declaracion::class, 'id_periodo');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function getActualAttribute()
    {
        $ahora = Carbon::now();
        return !$this->trashed() &&
                $this->desde->lte($ahora) && 
                $this->hasta->gte($ahora);
    }
}
