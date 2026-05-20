@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h1>
    <span class="text-muted" style="font-size:0.85rem;">
        {{ now()->translatedFormat('l, j \d\e F \d\e Y') }}
    </span>
</div>

{{-- TARJETAS SUPERIORES --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $stats['clientes'] ?? 0 }}</div>
                    <div class="stat-label">Clientes</div>
                </div>
                <i class="bi bi-people stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $stats['espacios_disponibles'] ?? 0 }}</div>
                    <div class="stat-label">Espacios Disponibles</div>
                </div>
                <i class="bi bi-grid-3x3-gap stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $stats['ventas_mes'] ?? 0 }}</div>
                    <div class="stat-label">Ventas este mes</div>
                </div>
                <i class="bi bi-cart-check stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $stats['cuotas_vencidas'] ?? 0 }}</div>
                    <div class="stat-label">Cuotas Vencidas</div>
                </div>
                <i class="bi bi-exclamation-triangle stat-icon" style="color:#dc3545;"></i>
            </div>
        </div>
    </div>
</div>

{{-- SEGUNDA FILA DE TARJETAS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $stats['contratos_activos'] ?? 0 }}</div>
                    <div class="stat-label">Contratos Activos</div>
                </div>
                <i class="bi bi-file-earmark-text stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ number_format($stats['saldo_pendiente_total'] ?? 0, 2) }}</div>
                    <div class="stat-label">Saldo Pendiente Total (BOB)</div>
                </div>
                <i class="bi bi-cash-coin stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $stats['mantenimientos_pendientes'] ?? 0 }}</div>
                    <div class="stat-label">Mantenimientos Pendientes</div>
                </div>
                <i class="bi bi-tools stat-icon"></i>
            </div>
        </div>
    </div>
</div>

{{-- GRÁFICAS --}}
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header py-2">
                <i class="bi bi-bar-chart me-2"></i>Ventas últimos 6 meses
            </div>
            <div class="card-body">
                <canvas id="ventasChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header py-2">
                <i class="bi bi-pie-chart me-2"></i>Estado de Espacios
            </div>
            <div class="card-body">
                <canvas id="espaciosChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- TABLAS INFERIORES --}}
<div class="row g-3">

    {{-- Inhumaciones recientes --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header py-2">
                <i class="bi bi-flower1 me-2"></i>Últimas Inhumaciones
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Fallecido</th>
                            <th>Espacio</th>
                            <th>Cementerio</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['inhumaciones_recientes'] as $inh)
                        <tr>
                            <td>{{ $inh->nombre }} {{ $inh->paterno }} {{ $inh->materno }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $inh->espacio->tipoInhumacion->nombre ?? '—' }}
                                </span>
                            </td>
                            <td>{{ $inh->espacio->cementerio->nombre ?? '—' }}</td>
                            <td>{{ $inh->fecha_inhumacion?->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Sin inhumaciones registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Cuotas por vencer --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header py-2">
                <i class="bi bi-calendar-event me-2"></i>Cuotas por Vencer (7 días)
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Vence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['cuotas_por_vencer'] as $cuota)
                        <tr>
                            <td>
                                {{ $cuota->planPago->pagoCredito->venta->cliente->nombre ?? '—' }}
                                {{ $cuota->planPago->pagoCredito->venta->cliente->paterno ?? '' }}
                            </td>
                            <td>{{ number_format($cuota->monto, 2) }} BOB</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Sin cuotas próximas a vencer</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const meses        = {!! json_encode($stats['meses'] ?? []) !!};
    const ventas       = {!! json_encode($stats['ventas_por_mes'] ?? []) !!};
    const espaciosData = {!! json_encode($stats['espacios_estado'] ?? [0,0,0,0]) !!};

    // Gráfica de barras — Ventas últimos 6 meses
    new Chart(document.getElementById('ventasChart'), {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Ventas (BOB)',
                data: ventas,
                backgroundColor: 'rgba(201,168,76,0.7)',
                borderColor: '#c9a84c',
                borderWidth: 2,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales:  { y: { beginAtZero: true } }
        }
    });

    // Gráfica de dona — Estado de Espacios
    new Chart(document.getElementById('espaciosChart'), {
        type: 'doughnut',
        data: {
            labels: ['Disponible', 'Ocupado', 'Mantenimiento', 'Reservado'],
            datasets: [{
                data: espaciosData,
                backgroundColor: ['#198754', '#dc3545', '#ffc107', '#0dcaf0'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush