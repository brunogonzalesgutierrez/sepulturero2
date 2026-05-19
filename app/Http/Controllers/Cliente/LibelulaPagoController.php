<?php
namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cuota;
use App\Models\Pago;
use App\Models\Empleado;
use App\Services\LibelulaService;
use App\Services\BitacoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibelulaPagoController extends Controller
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

        $identificador = 'CUOTA-' . $cuota->id . '-' . time();

        $resultado = LibelulaService::registrarDeuda([
            'email_cliente'     => $cliente->correo ?? Auth::user()->email,
            'identificador'     => $identificador,
            'descripcion'       => "Cuota #{$cuota->nro_cuota} — El Sepulturero Juan",
            'nombre_cliente'    => $cliente->nombre,
            'apellido_cliente'  => $cliente->paterno . ' ' . ($cliente->materno ?? ''),
            'ci'                => $cliente->ci,
            'moneda'            => $cuota->planPago->pagoCredito->venta->contrato->moneda ?? 'BOB',
            'fecha_vencimiento' => $cuota->fecha_vencimiento->format('Y-m-d'),
            'callback_url'      => route('cliente.libelula.callback'),
            'url_retorno'       => route('cliente.libelula.retorno', ['cuota' => $cuotaId]),
            'lineas_detalle_deuda' => [[
                'concepto'           => "Cuota #{$cuota->nro_cuota} — Cementerio El Sepulturero Juan",
                'cantidad'           => 1,
                'costo_unitario'     => floatval($cuota->monto),
                'descuento_unitario' => 0,
            ]],
            'lineas_metadatos' => [
                ['nombre' => 'Contrato', 'dato' => '#' . $cuota->planPago->pagoCredito->venta->contrato->id],
                ['nombre' => 'Cuota',    'dato' => "#{$cuota->nro_cuota}"],
                ['nombre' => 'CI',       'dato' => $cliente->ci],
            ],
        ]);

        if (isset($resultado['error']) && $resultado['error'] == 0) {
            session(['libelula_identificador_' . $cuotaId => $identificador]);

            // Si tiene QR, mostrar en tu página
            // Si no tiene QR, redirigir a la pasarela normal
            $qrUrl          = $resultado['qr_simple_url'] ?? null;
            $urlPasarela    = $resultado['url_pasarela_pagos'] ?? null;

            if ($qrUrl) {
                // Guardar en sesión para la vista del QR
                session([
                    'libelula_qr_'       . $cuotaId => $qrUrl,
                    'libelula_pasarela_' . $cuotaId => $urlPasarela,
                    'libelula_identificador_' . $cuotaId => $identificador,
                ]);

                return redirect()->route('cliente.libelula.qr', $cuotaId);
            }

            return redirect($urlPasarela);
        }

        return redirect()->route('cliente.cuotas')
            ->with('error', 'Error al conectar con Libélula: ' . ($resultado['mensaje'] ?? 'Error desconocido'));
    }

    /**
     * Callback GET que llama Libélula cuando el pago se confirma
     */
    public function callback(Request $request)
    {
        $transactionId = $request->get('transaction_id');

        if (!$transactionId) {
            return response('OK', 200);
        }

        // Consultar la deuda por identificador usando el transaction_id
        // Buscamos la cuota cuyo identificador contiene el transaction_id
        // Lo hacemos consultando directamente a Libélula
        $resultado = LibelulaService::consultarDeuda($transactionId);

        if (!isset($resultado['datos']) || empty($resultado['datos'])) {
            return response('OK', 200);
        }

        $datos = $resultado['datos'];
        if (!$datos['pagado']) {
            return response('OK', 200);
        }

        // Extraer el cuota_id del identificador (formato: CUOTA-{id}-{timestamp})
        $identificador = $datos['identificador'] ?? '';
        if (!preg_match('/^CUOTA-(\d+)-/', $identificador, $matches)) {
            return response('OK', 200);
        }

        $cuotaId = $matches[1];
        $this->procesarPago($cuotaId, $datos);

        return response('OK', 200);
    }

    /**
     * Retorno visual al cliente tras el pago
     */
    public function retorno(Request $request, $cuotaId)
    {
        $cuota = Cuota::find($cuotaId);

        if ($cuota && $cuota->estado !== 'pagada') {
            // Verificar con Libélula si ya se pagó
            $identificador = session('libelula_identificador_' . $cuotaId);

            if ($identificador) {
                $resultado = LibelulaService::consultarDeuda($identificador);

                if (isset($resultado['datos']['pagado']) && $resultado['datos']['pagado']) {
                    $this->procesarPago($cuotaId, $resultado['datos']);
                }
            }
        }

        return redirect()->route('cliente.cuotas')
            ->with('success', '¡Pago con Libélula procesado! Si no se refleja de inmediato, se actualizará en breve.');
    }

    private function procesarPago(int $cuotaId, array $datos): void
    {
        $cuota = Cuota::find($cuotaId);

        if (!$cuota || $cuota->estado === 'pagada') {
            return;
        }

        DB::transaction(function () use ($cuota, $datos) {
            $empleado = Empleado::first();

            $pago = Pago::create([
                'cuota_id'      => $cuota->id,
                'empleado_id'   => $empleado->id,
                'fecha_pago'    => now()->toDateString(),
                'monto_pagado'  => $cuota->monto,
                'monto_interes' => 0,
                'metodo_pago'   => 'transferencia',
                'comprobante'   => 'LIBELULA-' . ($datos['id_transaccion'] ?? $datos['codigo_recaudacion'] ?? 'N/A'),
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
                "Pago Libélula de {$cuota->monto} para cuota #{$cuota->nro_cuota} — forma: " . ($datos['forma_pago'] ?? 'N/A')
            );
        });
    }




    public function verificar(Request $request, $cuotaId)
    {
        $cuota         = Cuota::findOrFail($cuotaId);
        $identificador = session('libelula_identificador_' . $cuotaId);

        if (!$identificador) {
            return response()->json(['pagado' => false, 'error' => 'Sin identificador en sesión']);
        }

        $pagado = LibelulaService::verificarPago($identificador);

        if ($pagado) {
            $resultado = LibelulaService::consultarDeuda($identificador);
            $datos     = $resultado['datos'] ?? [];
            $this->procesarPago($cuotaId, $datos);
        }

        return response()->json([
            'pagado'      => $pagado,
            'redirect'    => $pagado ? route('cliente.libelula.retorno', $cuotaId) : null,
        ]);
    }




    public function mostrarQr(Request $request, $cuotaId)
    {
        $cuota = Cuota::whereHas('planPago.pagoCredito.venta.contrato', function($q) {
            $q->where('cliente_id', Auth::user()->cliente->id);
        })->with(['planPago.pagoCredito.venta.contrato.espacio.cementerio'])
        ->findOrFail($cuotaId);

        $qrUrl    = session('libelula_qr_'       . $cuotaId);
        $pasarela = session('libelula_pasarela_' . $cuotaId);

        if (!$qrUrl) {
            return redirect()->route('cliente.pagar', $cuotaId)
                ->with('error', 'El QR expiró. Genera uno nuevo.');
        }

        $contrato = $cuota->planPago->pagoCredito->venta->contrato;

        return view('cliente.libelula-qr', compact('cuota', 'qrUrl', 'pasarela', 'contrato'));
    }
}