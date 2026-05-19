<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoMantenimiento extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_mantenimientos';

    protected $fillable = ['nombre', 'descripcion', 'precio_base'];

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'tipo_mantenimiento_id');
    }
}