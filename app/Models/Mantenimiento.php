<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mantenimiento extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'espacio_id',
        'tipo_mantenimiento_id',
        'descripcion',
        'precio',
        'estado',
        'fecha_inicio',
        'fecha_fin'
    ];
    protected $casts = ['fecha_inicio' => 'date', 'fecha_fin' => 'date'];

    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }

    public function tipoMantenimiento()
    {
        return $this->belongsTo(TipoMantenimiento::class, 'tipo_mantenimiento_id');
    }

    public function ventaMantenimientos()
    {
        return $this->hasMany(VentaMantenimiento::class);
    }
}
