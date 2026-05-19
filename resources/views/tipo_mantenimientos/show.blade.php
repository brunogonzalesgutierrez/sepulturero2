@extends('layouts.app')
@section('title', 'Tipo de Mantenimiento #' . $tipo_mantenimiento->id)

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-tag me-2"></i>Tipo de Mantenimiento #{{ $tipo_mantenimiento->id }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('tipo_mantenimientos.edit', $tipo_mantenimiento) }}" class="btn btn-sm btn-gold">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('tipo_mantenimientos.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Volver
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- Información General --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="bi bi-info-circle me-1"></i>Información General
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th style="width:40%">ID</th>
                        <td>{{ $tipo_mantenimiento->id }}</td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td><span class="badge bg-secondary">{{ $tipo_mantenimiento->nombre }}</span></td>
                    </tr>
                    <tr>
                        <th>Precio Base</th>
                        <td><strong>{{ number_format($tipo_mantenimiento->precio_base, 2) }} BOB</strong></td>
                    </tr>
                    <tr>
                        <th>Fecha Creación</th>
                        <td>{{ $tipo_mantenimiento->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Última Actualización</th>
                        <td>{{ $tipo_mantenimiento->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Descripción --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="bi bi-card-text me-1"></i>Descripción
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $tipo_mantenimiento->descripcion ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Mantenimientos realizados con este tipo --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header py-2">
                <i class="bi bi-tools me-1"></i>Mantenimientos realizados con este tipo
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Espacio</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tipo_mantenimiento->mantenimientos as $m)
                            <tr>
                                <td class="text-muted" style="font-size:0.8rem;">{{ $m->id }}</td>
                                <td>{{ $m->espacio->cementerio->nombre }} -
                                    {{ $m->espacio->direccion->seccion ?? '?' }}/{{ $m->espacio->direccion->numero ?? '?' }}
                                </td>
                                <td>{{ number_format($m->precio, 2) }} BOB</td>
                                <td>{{ $m->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $m->estado }}">
                                        {{ ucfirst(str_replace('_', ' ', $m->estado)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('mantenimientos.show', $m) }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    <i class="bi bi-inbox d-block mb-1"></i>Ningún mantenimiento usa este tipo aún.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection