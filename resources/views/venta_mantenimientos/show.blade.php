@extends('layouts.app')
@section('title', 'Venta de Mantenimiento #' . $venta_mantenimiento->id)

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-cart-check me-2"></i>Venta de Mantenimiento #{{ $venta_mantenimiento->id }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('venta_mantenimientos.edit', $venta_mantenimiento) }}" class="btn btn-sm btn-gold">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('venta_mantenimientos.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Volver
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- Datos de la venta --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="bi bi-receipt me-1"></i>Datos de la Venta
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th style="width:40%">ID</th>
                        <td>{{ $venta_mantenimiento->id }}</td>
                    </tr>
                    <tr>
                        <th>Cliente</th>
                        <td>
                            {{ $venta_mantenimiento->cliente->nombre }}
                            {{ $venta_mantenimiento->cliente->paterno }}<br>
                            <small class="text-muted">CI: {{ $venta_mantenimiento->cliente->ci }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Empleado</th>
                        <td>
                            @if($venta_mantenimiento->empleado)
                                {{ $venta_mantenimiento->empleado->nombre }}
                                {{ $venta_mantenimiento->empleado->paterno }}
                            @else
                                <span class="text-muted">Solicitado por portal</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Precio</th>
                        <td><strong>{{ number_format($venta_mantenimiento->precio, 2) }} BOB</strong></td>
                    </tr>
                    <tr>
                        <th>Estado Pago</th>
                        <td>
                            <span class="badge {{ $venta_mantenimiento->estado_pago == 'pagado' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($venta_mantenimiento->estado_pago) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Método Pago</th>
                        <td>{{ $venta_mantenimiento->metodo_pago ? ucfirst($venta_mantenimiento->metodo_pago) : '—' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha Solicitud</th>
                        <td>{{ $venta_mantenimiento->fecha_solicitud->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Observación</th>
                        <td>{{ $venta_mantenimiento->observacion ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


<!--AAAAAAAAAAAAAAAAAAAAAAAAAAA -->

    {{-- Datos del mantenimiento --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="bi bi-tools me-1"></i>Servicio Solicitado
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th style="width:40%">Tipo</th>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $venta_mantenimiento->tipoMantenimiento->nombre ?? '—' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Descripción del tipo</th>
                        <td>{{ $venta_mantenimiento->tipoMantenimiento->descripcion ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Cementerio</th>
                        <td>{{ $venta_mantenimiento->espacio->cementerio->nombre ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Espacio</th>
                        <td>
                            Secc: {{ $venta_mantenimiento->espacio->direccion->seccion ?? '?' }} /
                            Nro: {{ $venta_mantenimiento->espacio->direccion->numero ?? '?' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection