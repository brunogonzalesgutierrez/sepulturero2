<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cuota;
use App\Models\Pago;
use App\Models\Empleado;
use App\Services\BitacoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CambioMonedaService;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalPagoController extends Controller
{
    public function pagar(Request $request, $cuotaId)
    {
        $cuota   = Cuota::findOrFail($cuotaId);
        $cliente = Auth::user()->cliente;

        // Verificar que la cuota pertenece al cliente
        $perteneceAlCliente = $cuota->planPago->pagoCredito->venta->contrato->cliente_id === $cliente->id;
        if (!$perteneceAlCliente) {
            return redirect()->route('cliente.dashboard')->with('error', 'Acceso no autorizado.');
        }

        if ($cuota->estado === 'pagada') {
            return redirect()->route('cliente.cuotas')->with('error', 'Esta cuota ya fue pagada.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        // Detectar moneda del contrato y convertir si es necesario
        $contrato = $cuota->planPago->pagoCredito->venta->contrato;
        $moneda   = $contrato->moneda;

        if ($moneda === 'BOB') {
            $montoUsd = CambioMonedaService::bobAUsd($cuota->monto);
            $tasa     = CambioMonedaService::tasaActual();
            $descripcion = "Cuota #{$cuota->nro_cuota} — {$cuota->monto} BOB (tasa: {$tasa})";
        } else {
            $montoUsd    = $cuota->monto;
            $descripcion = "Cuota #{$cuota->nro_cuota} — El Sepulturero Juan";
        }

        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value'         => number_format($montoUsd, 2, '.', ''),
                ],
                'description' => $descripcion,
            ]],
            'application_context' => [
                'return_url' => route('cliente.paypal.success', ['cuota' => $cuotaId]),
                'cancel_url' => route('cliente.paypal.cancel',  ['cuota' => $cuotaId]),
            ],
        ]);


        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect($link['href']);
            }
        }

        return redirect()->route('cliente.cuotas')->with('error', 'Error al conectar con PayPal.');
    }

    public function success(Request $request, $cuotaId)
    {
        $cuota    = Cuota::findOrFail($cuotaId);
        $cliente  = Auth::user()->cliente;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $result = $provider->capturePaymentOrder($request->token);

        if (isset($result['status']) && $result['status'] === 'COMPLETED') {
            DB::transaction(function () use ($cuota, $result, $cliente) {
                // Buscar empleado del sistema para registrar el pago
                $empleado = Empleado::first();

                $pago = Pago::create([
                    'cuota_id'      => $cuota->id,
                    'empleado_id'   => $empleado->id,
                    'fecha_pago'    => now()->toDateString(),
                    'monto_pagado'  => $cuota->monto,
                    'monto_interes' => 0,
                    'metodo_pago'   => 'transferencia',
                    'comprobante'   => 'PAYPAL-' . ($result['id'] ?? 'N/A'),
                ]);

                $cuota->update(['estado' => 'pagada']);

                // Actualizar saldo del contrato
                $contrato = $cuota->planPago->pagoCredito->venta->contrato;
                $nuevoSaldo = max(0, $contrato->saldo_pendiente - $cuota->monto);
                $contrato->update(['saldo_pendiente' => $nuevoSaldo]);

                if ($nuevoSaldo == 0) {
                    $contrato->update(['estado' => 'pagado']);
                }

                BitacoraService::registrar(
                    'pagos',
                    $pago->id,
                    "Pago PayPal de {$cuota->monto} por cliente #{$cliente->id} para cuota #{$cuota->nro_cuota}"
                );
            });

            return redirect()->route('cliente.cuotas')->with('success', '¡Pago con PayPal realizado exitosamente!');
        }

        return redirect()->route('cliente.cuotas')->with('error', 'El pago con PayPal no pudo completarse.');
    }

    public function cancel($cuotaId)
    {
        return redirect()->route('cliente.cuotas')->with('error', 'Pago con PayPal cancelado.');
    }
}
