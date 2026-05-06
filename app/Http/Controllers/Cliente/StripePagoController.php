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
use Stripe\Stripe;
use App\Services\CambioMonedaService;
use Stripe\Checkout\Session;

class StripePagoController extends Controller
{
    public function pagar(Request $request, $cuotaId)
    {
        $cuota   = Cuota::findOrFail($cuotaId);
        $cliente = Auth::user()->cliente;

        $perteneceAlCliente = $cuota->planPago->pagoCredito->venta->contrato->cliente_id === $cliente->id;
        if (!$perteneceAlCliente) {
            return redirect()->route('cliente.dashboard')->with('error', 'Acceso no autorizado.');
        }

        if ($cuota->estado === 'pagada') {
            return redirect()->route('cliente.cuotas')->with('error', 'Esta cuota ya fue pagada.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $contrato = $cuota->planPago->pagoCredito->venta->contrato;
        $moneda   = $contrato->moneda;

        if ($moneda === 'BOB') {
            $montoUsd = CambioMonedaService::bobAUsd($cuota->monto);
            $tasa     = CambioMonedaService::tasaActual();
            $nombreProducto = "Cuota #{$cuota->nro_cuota} ({$cuota->monto} BOB → {$montoUsd} USD)";
        } else {
            $montoUsd       = $cuota->monto;
            $nombreProducto = "Cuota #{$cuota->nro_cuota}";
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'unit_amount'  => intval($montoUsd * 100),
                    'product_data' => [
                        'name'        => $nombreProducto,
                        'description' => "Pago de cuota — El Sepulturero Juan",
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('cliente.stripe.success', ['cuota' => $cuotaId]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('cliente.stripe.cancel',  ['cuota' => $cuotaId]),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, $cuotaId)
    {
        $cuota   = Cuota::findOrFail($cuotaId);
        $cliente = Auth::user()->cliente;

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            DB::transaction(function () use ($cuota, $session, $cliente) {
                $empleado = Empleado::first();

                $pago = Pago::create([
                    'cuota_id'      => $cuota->id,
                    'empleado_id'   => $empleado->id,
                    'fecha_pago'    => now()->toDateString(),
                    'monto_pagado'  => $cuota->monto,
                    'monto_interes' => 0,
                    'metodo_pago'   => 'tarjeta',
                    'comprobante'   => 'STRIPE-' . $session->id,
                ]);

                $cuota->update(['estado' => 'pagada']);

                $contrato   = $cuota->planPago->pagoCredito->venta->contrato;
                $nuevoSaldo = max(0, $contrato->saldo_pendiente - $cuota->monto);
                $contrato->update(['saldo_pendiente' => $nuevoSaldo]);

                if ($nuevoSaldo == 0) {
                    $contrato->update(['estado' => 'pagado']);
                }

                BitacoraService::registrar(
                    'pagos',
                    $pago->id,
                    "Pago Stripe de {$cuota->monto} por cliente #{$cliente->id} para cuota #{$cuota->nro_cuota}"
                );
            });

            return redirect()->route('cliente.cuotas')->with('success', '¡Pago con Stripe realizado exitosamente!');
        }

        return redirect()->route('cliente.cuotas')->with('error', 'El pago con Stripe no pudo completarse.');
    }

    public function cancel($cuotaId)
    {
        return redirect()->route('cliente.cuotas')->with('error', 'Pago con Stripe cancelado.');
    }
}
