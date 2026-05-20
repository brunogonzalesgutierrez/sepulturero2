<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoInhumacion extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_inhumaciones';

    protected $fillable = [
        'nombre',
        'precio',      // precio fijo de inhumación según el tipo
        'precio_m2',   // precio por m² según el tipo (antes precio_base)
        'capacidad_max',
        'estado',
        'area_base'
    ];

    public function espacios()
    {
        return $this->hasMany(Espacio::class);
    }
}