@extends('layouts.app')
@section('title', 'Tipos de Mantenimiento')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-tag me-2"></i>Tipos de Mantenimiento</h1>
    <a href="{{ route('tipo_mantenimientos.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Tipo
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <input type="text" name="buscar" class="form-control form-control-sm"
                    placeholder="Buscar por nombre..."
                    value="{{ request('buscar') }}">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('tipo_mantenimientos.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio Base (BOB)</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tipos as $tipo)
                    <tr>
                        <td class="text-muted" style="font-size:0.8rem;">{{ $tipo->id }}</td>
                        <td><span class="badge bg-secondary">{{ $tipo->nombre }}</span></td>
                        <td>{{ Str::limit($tipo->descripcion, 60) }}</td>
                        <td>{{ number_format($tipo->precio_base, 2) }}</td>
                        <td class="text-center">
                            <a href="{{ route('tipo_mantenimientos.show', $tipo) }}"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('tipo_mantenimientos.edit', $tipo) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('tipo_mantenimientos.destroy', $tipo) }}"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar este tipo de mantenimiento?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>No hay tipos de mantenimiento registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tipos->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center py-2">
        <small class="text-muted">{{ $tipos->firstItem() }}–{{ $tipos->lastItem() }} de {{ $tipos->total() }}</small>
        {{ $tipos->links() }}
    </div>
    @endif
</div>
@endsection