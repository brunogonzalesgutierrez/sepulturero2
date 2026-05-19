<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaMantenimiento extends Model
{
    use SoftDeletes;

    protected $table = 'venta_mantenimientos';

    protected $fillable = [
        'mantenimiento_id',
        'espacio_id',
        'tipo_mantenimiento_id',
        'cliente_id',
        'empleado_id',
        'precio',
        'estado_pago',
        'metodo_pago',
        'fecha_solicitud',
        'observacion',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
    ];

    public function mantenimiento()
    {
        return $this->belongsTo(Mantenimiento::class);
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }

    public function tipoMantenimiento()
    {
        return $this->belongsTo(TipoMantenimiento::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}