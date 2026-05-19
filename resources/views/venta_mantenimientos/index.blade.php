@extends('layouts.app')
@section('title', 'Ventas de Mantenimiento')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-cart-check me-2"></i>Ventas de Mantenimiento</h1>
    <a href="{{ route('venta_mantenimientos.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-lg me-1"></i>Nueva Venta
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="buscar" class="form-control form-control-sm"
                    placeholder="Buscar por cliente (nombre, CI)..."
                    value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <select name="estado_pago" class="form-select form-select-sm">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="pagado"    {{ request('estado_pago') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('venta_mantenimientos.index') }}" class="btn btn-sm btn-outline-secondary w-100">
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
                        <th>Cliente</th>
                        <th>Mantenimiento</th>
                        <th>Espacio</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Estado Pago</th>
                        <th>Método</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $v)
                    <tr>
                        <td class="text-muted" style="font-size:0.8rem;">{{ $v->id }}</td>
                        <td>
                            {{ $v->cliente->nombre }} {{ $v->cliente->paterno }}<br>
                            <small class="text-muted">CI: {{ $v->cliente->ci }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $v->tipoMantenimiento->nombre ?? '—' }}
                            </span>
                        </td>
                        <td>
                            {{ $v->espacio->cementerio->nombre ?? '—' }}<br>
                            <small class="text-muted">
                                Secc: {{ $v->espacio->direccion->seccion ?? '?' }} /
                                Nro: {{ $v->espacio->direccion->numero ?? '?' }}
                            </small>
                        </td>
                        <td>{{ number_format($v->precio, 2) }} BOB</td>
                        <td>{{ $v->fecha_solicitud->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $v->estado_pago == 'pagado' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($v->estado_pago) }}
                            </span>
                        </td>
                        <td>{{ $v->metodo_pago ? ucfirst($v->metodo_pago) : '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('venta_mantenimientos.show', $v) }}"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('venta_mantenimientos.edit', $v) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('venta_mantenimientos.destroy', $v) }}"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar esta venta?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>No hay ventas de mantenimiento registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($ventas->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center py-2">
        <small class="text-muted">{{ $ventas->firstItem() }}–{{ $ventas->lastItem() }} de {{ $ventas->total() }}</small>
        {{ $ventas->links() }}
    </div>
    @endif
</div>
@endsection