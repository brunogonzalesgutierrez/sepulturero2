<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Espacio;
use App\Models\TipoMantenimiento;
use App\Http\Requests\MantenimientoRequest;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('mantenimientos.ver');

        $query = Mantenimiento::with(['espacio.cementerio', 'espacio.direccion', 'tipoMantenimiento']);

        if ($request->filled('buscar')) {
            $b = $request->buscar;
            $query->where('descripcion', 'like', "%$b%")
                ->orWhereHas('espacio.cementerio', fn($q) => $q->where('nombre', 'like', "%$b%"));
        }

        if ($request->filled('tipo')) {
            $query->where('tipo_mantenimiento_id', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $mantenimientos       = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $tiposMantenimiento   = TipoMantenimiento::orderBy('nombre')->get();

        return view('mantenimientos.index', compact('mantenimientos', 'tiposMantenimiento'));
    }

    public function create()
    {
        $this->authorize('mantenimientos.crear');

        $espacios           = Espacio::with(['cementerio', 'direccion'])->orderBy('id')->get();
        $tiposMantenimiento = TipoMantenimiento::orderBy('nombre')->get();
        $mantenimiento      = new Mantenimiento();

        return view('mantenimientos.create', compact('espacios', 'mantenimiento', 'tiposMantenimiento'));
    }

    public function store(MantenimientoRequest $request)
    {
        $this->authorize('mantenimientos.crear');

        $mantenimiento = Mantenimiento::create($request->validated());

        if (in_array($request->estado, ['pendiente', 'en_proceso'])) {
            $mantenimiento->espacio->update(['estado' => 'mantenimiento']);
        }

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento registrado correctamente.');
    }

    public function show(Mantenimiento $mantenimiento)
    {
        $this->authorize('mantenimientos.ver');

        $mantenimiento->load([
            'espacio.cementerio',
            'espacio.direccion',
            'espacio.tipoInhumacion',
            'tipoMantenimiento',
        ]);

        return view('mantenimientos.show', compact('mantenimiento'));
    }

    public function edit(Mantenimiento $mantenimiento)
    {
        $this->authorize('mantenimientos.editar');

        $espacios           = Espacio::with(['cementerio', 'direccion'])->orderBy('id')->get();
        $tiposMantenimiento = TipoMantenimiento::orderBy('nombre')->get();

        return view('mantenimientos.edit', compact('mantenimiento', 'espacios', 'tiposMantenimiento'));
    }

    public function update(MantenimientoRequest $request, Mantenimiento $mantenimiento)
    {
        $this->authorize('mantenimientos.editar');

        $estadoAnterior = $mantenimiento->estado;
        $mantenimiento->update($request->validated());

        if ($request->estado === 'completado' && $estadoAnterior !== 'completado') {
            $espacio         = $mantenimiento->espacio;
            $tieneInhumaciones = $espacio->inhumaciones()->count() > 0;
            $espacio->update(['estado' => $tieneInhumaciones ? 'ocupado' : 'disponible']);
        }

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function destroy(Mantenimiento $mantenimiento)
    {
        $this->authorize('mantenimientos.eliminar');

        $mantenimiento->delete();

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento eliminado.');
    }
}