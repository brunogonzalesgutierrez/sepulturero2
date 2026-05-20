<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Espacio;
use App\Models\Venta;
use App\Models\Cuota;
use App\Models\Contrato;
use App\Models\Inhumacion;
use App\Models\Mantenimiento;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            // Tarjetas superiores
            'clientes'              => Cliente::count(),
            'espacios_disponibles'  => Espacio::where('estado', 'disponible')->count(),
            'ventas_mes'            => Venta::whereMonth('fecha_venta', now()->month)
                                           ->whereYear('fecha_venta', now()->year)->count(),
            'cuotas_vencidas'       => Cuota::where('estado', 'vencida')->count(),

            // Gráficas
            'meses'                 => collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->isoFormat('MMM'))->values(),
            'ventas_por_mes'        => collect(range(5, 0))->map(
                fn($i) => Venta::whereMonth('fecha_venta', now()->subMonths($i)->month)
                               ->whereYear('fecha_venta', now()->subMonths($i)->year)
                               ->sum('precio_total')
            )->values(),
            'espacios_estado'       => [
                Espacio::where('estado', 'disponible')->count(),
                Espacio::where('estado', 'ocupado')->count(),
                Espacio::where('estado', 'mantenimiento')->count(),
                Espacio::where('estado', 'reservado')->count(),
            ],

            // Nuevos widgets
            'contratos_activos'     => Contrato::where('estado', 'activo')->count(),
            'saldo_pendiente_total' => Contrato::where('estado', 'activo')->sum('saldo_pendiente'),
            'mantenimientos_pendientes' => Mantenimiento::where('estado', 'pendiente')->count(),

            'inhumaciones_recientes' => Inhumacion::with(['espacio.cementerio', 'espacio.tipoInhumacion'])
                                            ->orderBy('fecha_inhumacion', 'desc')
                                            ->limit(5)
                                            ->get(),

            'cuotas_por_vencer'     => Cuota::with(['planPago.pagoCredito.venta.cliente'])
                                            ->where('estado', 'pendiente')
                                            ->whereBetween('fecha_vencimiento', [now()->toDateString(), now()->addDays(7)->toDateString()])
                                            ->orderBy('fecha_vencimiento')
                                            ->limit(5)
                                            ->get(),
        ];

        return view('dashboard', compact('stats'));
    }
}