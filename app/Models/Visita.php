<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $fillable = ['ruta', 'nombre', 'total'];

    public static function registrar(string $ruta, string $nombre = null): int
    {
        $visita = self::firstOrCreate(
            ['ruta' => $ruta],
            ['nombre' => $nombre, 'total' => 0]
        );

        $visita->increment('total');

        return $visita->total;
    }
}