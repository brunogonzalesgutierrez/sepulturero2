<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\VentaMantenimiento;
use App\Models\Empleado;
use App\Services\LibelulaService;
use App\Services\BitacoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibelulaMantenimientoPagoController extends Controller
{
    public function pagar(Request $request, $ventaId)
    {
        $cliente = Auth::user()->cliente;
        $venta   = VentaMantenimiento::with(['tipoMantenimiento', 'espacio'])
            ->where('cliente_id', $cliente->id)
            ->findOrFail($ventaId);

        if ($venta->estado_pago === 'pagado') {
            return redirect()->route('cliente.mantenimientos.index')
                ->with('error', 'Este mantenimiento ya fue pagado.');
        }

        $identificador = 'MANT-' . $venta->id . '-' . time();

        $resultado = LibelulaService::registrarDeuda([
            'email_cliente'     => $cliente->correo ?? Auth::user()->email,
            'identificador'     => $identificador,
            'descripcion'       => "Mantenimiento — El Sepulturero Juan",
            'nombre_cliente'    => $cliente->nombre,
            'apellido_cliente'  => $cliente->paterno . ' ' . ($cliente->materno ?? ''),
            'ci'                => $cliente->ci,
            'moneda'            => 'BOB',
            'fecha_vencimiento' => now()->addDays(7)->format('Y-m-d'),
            'callback_url'      => route('cliente.libelula.mantenimiento.callback'),
            'url_retorno'       => route('cliente.libelula.mantenimiento.retorno', ['venta' => $ventaId]),
            'lineas_detalle_deuda' => [[
                'concepto'           => $venta->tipoMantenimiento->nombre . ' — Cementerio El Sepulturero Juan',
                'cantidad'           => 1,
                'costo_unitario'     => floatval($venta->precio),
                'descuento_unitario' => 0,
            ]],
            'lineas_metadatos' => [
                ['nombre' => 'Tipo',   'dato' => $venta->tipoMantenimiento->nombre ?? 'N/A'],
                ['nombre' => 'Espacio','dato' => 'ID #' . $venta->espacio_id],
                ['nombre' => 'CI',     'dato' => $cliente->ci],
            ],
        ]);

        if (isset($resultado['error']) && $resultado['error'] == 0 && isset($resultado['url_pasarela_pagos'])) {
            session(['libelula_mant_' . $ventaId => $identificador]);
            return redirect($resultado['url_pasarela_pagos']);
        }

        return redirect()->route('cliente.mantenimientos.index')
            ->with('error', 'Error al conectar con Libélula: ' . ($resultado['mensaje'] ?? 'Error desconocido'));
    }

    public function callback(Request $request)
    {
        $transactionId = $request->get('transaction_id');

        if (!$transactionId) {
            return response('OK', 200);
        }

        $resultado = LibelulaService::consultarDeuda($transactionId);

        if (!isset($resultado['datos']) || empty($resultado['datos'])) {
            return response('OK', 200);
        }

        $datos = $resultado['datos'];
        if (!$datos['pagado']) {
            return response('OK', 200);
        }

        $identificador = $datos['identificador'] ?? '';
        if (!preg_match('/^MANT-(\d+)-/', $identificador, $matches)) {
            return response('OK', 200);
        }

        $this->procesarPago($matches[1], $datos);

        return response('OK', 200);
    }

    public function retorno(Request $request, $ventaId)
    {
        $venta = VentaMantenimiento::find($ventaId);

        if ($venta && $venta->estado_pago !== 'pagado') {
            $identificador = session('libelula_mant_' . $ventaId);

            if ($identificador) {
                $resultado = LibelulaService::consultarDeuda($identificador);

                if (isset($resultado['datos']['pagado']) && $resultado['datos']['pagado']) {
                    $this->procesarPago($ventaId, $resultado['datos']);
                }
            }
        }

        return redirect()->route('cliente.mantenimientos.index')
            ->with('success', '¡Pago con Libélula procesado! Si no se refleja de inmediato, se actualizará en breve.');
    }

    private function procesarPago(int $ventaId, array $datos): void
    {
        $venta = VentaMantenimiento::find($ventaId);

        if (!$venta || $venta->estado_pago === 'pagado') {
            return;
        }

        DB::transaction(function () use ($venta, $datos) {
            $venta->update([
                'estado_pago' => 'pagado',
                'metodo_pago' => 'online',
            ]);

            BitacoraService::registrar(
                'venta_mantenimientos',
                $venta->id,
                "Pago Libélula de {$venta->precio} BOB para mantenimiento #{$venta->id} — forma: " . ($datos['forma_pago'] ?? 'N/A')
            );
        });
    }
}