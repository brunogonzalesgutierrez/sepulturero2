<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\TipoMantenimiento;
use App\Models\VentaMantenimiento;
use App\Models\Contrato;
use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ClienteMantenimientoController extends Controller
{
    private function cliente()
    {
        return Auth::user()->cliente;
    }

    public function index()
    {
        $cliente = $this->cliente();

        $ventas = VentaMantenimiento::with([
            'tipoMantenimiento',
            'espacio.cementerio',
            'espacio.direccion',
        ])->where('cliente_id', $cliente->id)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('cliente.mantenimientos.index', compact('ventas', 'cliente'));
    }

    public function create()
    {
        $cliente = $this->cliente();

        $espacios = \App\Models\Espacio::with([
            'cementerio',
            'direccion',
            'tipoInhumacion',
        ])->whereHas('contratos', function ($q) use ($cliente) {
            $q->where('cliente_id', $cliente->id)
            ->where('estado', 'activo');
        })->get();

        $tipos = TipoMantenimiento::orderBy('nombre')->get();

        return view('cliente.mantenimientos.create', compact('espacios', 'tipos', 'cliente'));
    }

    public function store(Request $request)
    {
        $cliente = $this->cliente();

        $request->validate([
            'espacio_id'            => 'required|exists:espacios,id',
            'tipo_mantenimiento_id' => 'required|exists:tipo_mantenimientos,id',
            'observacion'           => 'nullable|string|max:500',
        ]);

        $tieneContrato = Contrato::where('cliente_id', $cliente->id)
            ->where('espacio_id', $request->espacio_id)
            ->where('estado', 'activo')
            ->exists();

        if (!$tieneContrato) {
            return back()->withErrors(['espacio_id' => 'No tiene un contrato activo para ese espacio.']);
        }

        $tipo = TipoMantenimiento::findOrFail($request->tipo_mantenimiento_id);

        VentaMantenimiento::create([
            'espacio_id'            => $request->espacio_id,
            'tipo_mantenimiento_id' => $request->tipo_mantenimiento_id,
            'cliente_id'            => $cliente->id,
            'empleado_id'           => null,
            'precio'                => $tipo->precio_base,
            'estado_pago'           => 'pendiente',
            'metodo_pago'           => null,
            'fecha_solicitud'       => now()->toDateString(),
            'observacion'           => $request->observacion,
        ]);

        return redirect()->route('cliente.mantenimientos.index')
            ->with('success', 'Solicitud enviada correctamente. Nos pondremos en contacto pronto.');
    }



    public function pagar($ventaId)
    {
        $cliente = $this->cliente();

        $venta = VentaMantenimiento::with(['tipoMantenimiento', 'espacio.cementerio'])
            ->where('cliente_id', $cliente->id)
            ->where('estado_pago', 'pendiente')
            ->findOrFail($ventaId);

        return view('cliente.mantenimientos.pagar', compact('venta', 'cliente'));
    }



}