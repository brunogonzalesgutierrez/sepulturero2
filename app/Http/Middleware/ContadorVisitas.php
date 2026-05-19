<?php
namespace App\Http\Middleware;

use App\Models\Visita;
use Closure;
use Illuminate\Http\Request;

class ContadorVisitas
{
    // Rutas que NO queremos contar (assets, ajax, etc.)
    private array $excluir = [
        'login', 'logout', 'register',
        '2fa', 'paypal', 'stripe', 'libelula',
    ];

    public function handle(Request $request, Closure $next)
    {
        // Contar ANTES de procesar la respuesta
        if ($request->isMethod('GET') && !$request->ajax()) {
            $ruta = $request->path() === '/' ? 'home' : $request->path();

            $excluir = false;
            foreach ($this->excluir as $patron) {
                if (str_contains($ruta, $patron)) {
                    $excluir = true;
                    break;
                }
            }

            if (!$excluir) {
                $nombre = $this->nombreLegible($ruta);
                $total  = Visita::registrar($ruta, $nombre);
                view()->share('visitas_pagina', $total);
            }
        }

        return $next($request);
    }

    private function nombreLegible(string $ruta): string
    {
        $nombres = [
            'home'          => 'Inicio',
            'sistema'       => 'Dashboard',
            'clientes'      => 'Clientes',
            'empleados'     => 'Empleados',
            'cementerios'   => 'Cementerios',
            'espacios'      => 'Espacios',
            'contratos'     => 'Contratos',
            'ventas'        => 'Ventas',
            'pagos'         => 'Pagos',
            'reportes'      => 'Reportes',
            'bitacora'      => 'Bitácora',
            'perfil'        => 'Perfil',
            'cliente/dashboard' => 'Portal Cliente',
            'cliente/cuotas'    => 'Mis Cuotas',
            'cliente/perfil'    => 'Mi Perfil',
        ];

        foreach ($nombres as $key => $nombre) {
            if (str_starts_with($ruta, $key)) {
                return $nombre;
            }
        }

        return ucfirst(str_replace('/', ' › ', $ruta));
    }
}