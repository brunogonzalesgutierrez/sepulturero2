<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoInhumacion;
use App\Models\Cementerio;
use App\Models\Dimension;
use App\Models\Espacio;

class EspaciosSeeder extends Seeder
{
    public function run(): void
    {
        // Tipos de inhumación
        $tipos = [
            ['nombre' => 'nicho',      'precio' => 500,  'precio_base' => 500,  'capacidad_max' => 1, 'area_base' => 2.5,  'estado' => 'activo'],
            ['nombre' => 'mausoleo',   'precio' => 2000, 'precio_base' => 2000, 'capacidad_max' => 8, 'area_base' => 25.0, 'estado' => 'activo'],
            ['nombre' => 'lote',       'precio' => 800,  'precio_base' => 800,  'capacidad_max' => 4, 'area_base' => 12.0, 'estado' => 'activo'],
            ['nombre' => 'individual', 'precio' => 300,  'precio_base' => 300,  'capacidad_max' => 1, 'area_base' => 3.0,  'estado' => 'activo'],
        ];

        foreach ($tipos as $tipo) {
            TipoInhumacion::firstOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }

        // Cementerio principal
        $cementerio = Cementerio::first();

        // Dimensiones
        $dims = [
            ['ancho' => 1.5, 'largo' => 2.0],
            ['ancho' => 2.0, 'largo' => 3.0],
            ['ancho' => 5.0, 'largo' => 5.0],
            ['ancho' => 2.5, 'largo' => 4.0],
        ];

        $dimensiones = [];
        foreach ($dims as $d) {
            $dimensiones[] = Dimension::create($d);
        }

        $tiposDB = TipoInhumacion::all()->keyBy('nombre');

        // Crear 20 espacios disponibles variados
        $espacios = [
            ['tipo' => 'nicho',      'estado' => 'disponible', 'precio_m2' => 150, 'dim' => 0],
            ['tipo' => 'nicho',      'estado' => 'disponible', 'precio_m2' => 150, 'dim' => 0],
            ['tipo' => 'nicho',      'estado' => 'disponible', 'precio_m2' => 180, 'dim' => 0],
            ['tipo' => 'nicho',      'estado' => 'ocupado',    'precio_m2' => 150, 'dim' => 0],
            ['tipo' => 'mausoleo',   'estado' => 'disponible', 'precio_m2' => 300, 'dim' => 2],
            ['tipo' => 'mausoleo',   'estado' => 'disponible', 'precio_m2' => 350, 'dim' => 2],
            ['tipo' => 'mausoleo',   'estado' => 'ocupado',    'precio_m2' => 300, 'dim' => 2],
            ['tipo' => 'lote',       'estado' => 'disponible', 'precio_m2' => 200, 'dim' => 3],
            ['tipo' => 'lote',       'estado' => 'disponible', 'precio_m2' => 220, 'dim' => 3],
            ['tipo' => 'lote',       'estado' => 'disponible', 'precio_m2' => 200, 'dim' => 3],
            ['tipo' => 'lote',       'estado' => 'ocupado',    'precio_m2' => 200, 'dim' => 3],
            ['tipo' => 'individual', 'estado' => 'disponible', 'precio_m2' => 100, 'dim' => 1],
            ['tipo' => 'individual', 'estado' => 'disponible', 'precio_m2' => 100, 'dim' => 1],
            ['tipo' => 'individual', 'estado' => 'disponible', 'precio_m2' => 120, 'dim' => 1],
            ['tipo' => 'individual', 'estado' => 'ocupado',    'precio_m2' => 100, 'dim' => 1],
        ];

        foreach ($espacios as $e) {
            Espacio::create([
                'cementerio_id'       => $cementerio->id,
                'dimension_id'        => $dimensiones[$e['dim']]->id,
                'tipo_inhumacion_id'  => $tiposDB[$e['tipo']]->id,
                'estado'              => $e['estado'],
                'precio_m2'           => $e['precio_m2'],
            ]);
        }
    }
}