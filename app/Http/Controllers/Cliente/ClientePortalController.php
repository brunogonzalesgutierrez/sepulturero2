<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientePortalController extends Controller
{
    private function cliente()
    {
        return Auth::user()->cliente;
    }

    public function dashboard()
    {
        $cliente   = $this->cliente();
        $contratos = $cliente->contratos()
            ->with(['espacio.cementerio', 'espacio.tipoInhumacion', 'venta.pagoCredito.planPago.cuotas'])
            ->get();

        $cuotasPendientes = Cuota::whereHas('planPago.pagoCredito.venta.contrato', function ($q) use ($cliente) {
            $q->where('cliente_id', $cliente->id);
        })->whereIn('estado', ['pendiente', 'vencida'])
            ->orderBy('fecha_vencimiento')
            ->get();

        $totalPendiente = $cuotasPendientes->sum('monto');

        return view('cliente.dashboard', compact('cliente', 'contratos', 'cuotasPendientes', 'totalPendiente'));
    }

    public function contrato($id)
    {
        $cliente  = $this->cliente();
        $contrato = $cliente->contratos()
            ->with([
                'espacio.cementerio',
                'espacio.direccion',
                'espacio.tipoInhumacion',
                'espacio.dimension',
                'venta.pagoContado',
                'venta.pagoCredito.planPago.cuotas.pagos',
                'inhumaciones',
            ])
            ->findOrFail($id);

        return view('cliente.contrato', compact('contrato'));
    }

    public function cuotas()
    {
        $cliente = $this->cliente();

        $cuotas = Cuota::whereHas('planPago.pagoCredito.venta.contrato', function ($q) use ($cliente) {
            $q->where('cliente_id', $cliente->id);
        })->with(['planPago.pagoCredito.venta.contrato'])
            ->orderBy('fecha_vencimiento')
            ->get();

        return view('cliente.cuotas', compact('cuotas'));
    }


    public function pagar($cuotaId)
    {
        $cliente = $this->cliente();
        $cuota   = Cuota::whereHas('planPago.pagoCredito.venta.contrato', function ($q) use ($cliente) {
            $q->where('cliente_id', $cliente->id);
        })->with(['planPago.pagoCredito.venta.contrato'])
            ->findOrFail($cuotaId);

        if ($cuota->estado === 'pagada') {
            return redirect()->route('cliente.cuotas')->with('error', 'Esta cuota ya fue pagada.');
        }

        $moneda   = $cuota->planPago->pagoCredito->venta->contrato->moneda;
        $montoUsd = $moneda === 'BOB'
            ? \App\Services\CambioMonedaService::bobAUsd($cuota->monto)
            : $cuota->monto;
        $tasa     = $moneda === 'BOB'
            ? \App\Services\CambioMonedaService::tasaActual()
            : null;

        return view('cliente.pagar', compact('cuota', 'moneda', 'montoUsd', 'tasa'));
    }

    public function perfil()
    {
        $cliente = $this->cliente();
        $user    = Auth::user();
        return view('cliente.perfil', compact('cliente', 'user'));
    }

    public function actualizarPerfil(\Illuminate\Http\Request $request)
    {
        $user    = Auth::user();
        $cliente = $this->cliente();

        $request->validate([
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'Mínimo 8 caracteres.',
        ]);

        // Actualizar datos del cliente
        $cliente->update([
            'telefono' => $request->telefono,
            'correo'   => $request->correo,
            'direccion' => $request->direccion,
        ]);

        // Actualizar correo del usuario si cambió
        if ($request->correo && $request->correo !== $user->email) {
            $user->update(['email' => $request->correo]);
        }

        // Cambiar contraseña si se proporcionó
        if ($request->filled('password')) {
            $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
