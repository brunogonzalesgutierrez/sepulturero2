<?php

namespace App\Http\Controllers;

use App\Models\VentaMantenimiento;
use App\Models\Mantenimiento;
use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;

class VentaMantenimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = VentaMantenimiento::with([
            'tipoMantenimiento',
            'espacio.cementerio',
            'espacio.direccion',
            'cliente',
            'empleado',
        ]);

        if ($request->filled('buscar')) {
            $b = $request->buscar;
            $query->whereHas('cliente', fn($q) =>
                $q->where('nombre', 'like', "%$b%")
                  ->orWhere('paterno', 'like', "%$b%")
                  ->orWhere('ci', 'like', "%$b%")
            );
        }

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        $ventas = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('venta_mantenimientos.index', compact('ventas'));
    }

    public function create()
    {
        $mantenimientos = Mantenimiento::with([
            'tipoMantenimiento',
            'espacio.cementerio',
            'espacio.direccion',
        ])->whereIn('estado', ['pendiente', 'en_proceso'])->get();

        $clientes  = Cliente::where('estado', 'activo')->orderBy('paterno')->get();
        $empleados = Empleado::where('estado', 'activo')->orderBy('nombre')->get();
        $venta     = new VentaMantenimiento();

        return view('venta_mantenimientos.create', compact(
            'mantenimientos', 'clientes', 'empleados', 'venta'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mantenimiento_id' => 'required|exists:mantenimientos,id',
            'cliente_id'       => 'required|exists:clientes,id',
            'empleado_id'      => 'nullable|exists:empleados,id',
            'precio'           => 'required|numeric|min:0',
            'estado_pago'      => 'required|in:pendiente,pagado',
            'metodo_pago'      => 'nullable|in:efectivo,transferencia,qr,online',
            'fecha_solicitud'  => 'required|date',
            'observacion'      => 'nullable|string|max:500',
        ]);

        VentaMantenimiento::create([
            'mantenimiento_id' => $request->mantenimiento_id,
            'cliente_id'       => $request->cliente_id,
            'empleado_id'      => $request->empleado_id ?? auth()->user()->empleado_id,
            'precio'           => $request->precio,
            'estado_pago'      => $request->estado_pago,
            'metodo_pago'      => $request->metodo_pago,
            'fecha_solicitud'  => $request->fecha_solicitud,
            'observacion'      => $request->observacion,
        ]);

        return redirect()->route('venta_mantenimientos.index')
            ->with('success', 'Venta de mantenimiento registrada correctamente.');
    }

    public function show(VentaMantenimiento $venta_mantenimiento)
    {
        $venta_mantenimiento->load([
            'mantenimiento.tipoMantenimiento',
            'mantenimiento.espacio.cementerio',
            'mantenimiento.espacio.direccion',
            'cliente',
            'empleado',
        ]);

        return view('venta_mantenimientos.show', compact('venta_mantenimiento'));
    }

    public function edit(VentaMantenimiento $venta_mantenimiento)
    {
        $mantenimientos = Mantenimiento::with([
            'tipoMantenimiento',
            'espacio.cementerio',
            'espacio.direccion',
        ])->whereIn('estado', ['pendiente', 'en_proceso'])->get();

        $clientes  = Cliente::where('estado', 'activo')->orderBy('paterno')->get();
        $empleados = Empleado::where('estado', 'activo')->orderBy('nombre')->get();

        return view('venta_mantenimientos.edit', compact(
            'venta_mantenimiento', 'mantenimientos', 'clientes', 'empleados'
        ));
    }

    public function update(Request $request, VentaMantenimiento $venta_mantenimiento)
    {
        $request->validate([
            'mantenimiento_id' => 'required|exists:mantenimientos,id',
            'cliente_id'       => 'required|exists:clientes,id',
            'empleado_id'      => 'nullable|exists:empleados,id',
            'precio'           => 'required|numeric|min:0',
            'estado_pago'      => 'required|in:pendiente,pagado',
            'metodo_pago'      => 'nullable|in:efectivo,transferencia,qr,online',
            'fecha_solicitud'  => 'required|date',
            'observacion'      => 'nullable|string|max:500',
        ]);

        $venta_mantenimiento->update($request->all());

        return redirect()->route('venta_mantenimientos.index')
            ->with('success', 'Venta de mantenimiento actualizada.');
    }

    public function destroy(VentaMantenimiento $venta_mantenimiento)
    {
        $venta_mantenimiento->delete();

        return redirect()->route('venta_mantenimientos.index')
            ->with('success', 'Venta de mantenimiento eliminada.');
    }
}