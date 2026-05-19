<?php

namespace App\Http\Controllers;

use App\Models\TipoMantenimiento;
use Illuminate\Http\Request;

class TipoMantenimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoMantenimiento::withCount('mantenimientos');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $tipos = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('tipo_mantenimientos.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipo_mantenimientos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_mantenimientos,nombre',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
        ]);

        TipoMantenimiento::create($request->only('nombre', 'descripcion', 'precio_base'));

        return redirect()->route('tipo_mantenimientos.index')
            ->with('success', 'Tipo de mantenimiento creado correctamente.');
    }

    public function show(TipoMantenimiento $tipo_mantenimiento)
    {
        $tipo_mantenimiento->load(['mantenimientos.espacio.cementerio']);
        return view('tipo_mantenimientos.show', compact('tipo_mantenimiento'));
    }

    public function edit(TipoMantenimiento $tipo_mantenimiento)
    {
        return view('tipo_mantenimientos.edit', compact('tipo_mantenimiento'));
    }

    public function update(Request $request, TipoMantenimiento $tipo_mantenimiento)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_mantenimientos,nombre,' . $tipo_mantenimiento->id,
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
        ]);

        $tipo_mantenimiento->update($request->only('nombre', 'descripcion', 'precio_base'));

        return redirect()->route('tipo_mantenimientos.index')
            ->with('success', 'Tipo de mantenimiento actualizado.');
    }

    public function destroy(TipoMantenimiento $tipo_mantenimiento)
    {
        $tipo_mantenimiento->delete();

        return redirect()->route('tipo_mantenimientos.index')
            ->with('success', 'Tipo de mantenimiento eliminado.');
    }
}