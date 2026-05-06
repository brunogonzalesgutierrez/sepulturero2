<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Contrato — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #c9a84c;
            --accent-hover: #e8c96a;
            --text: #e0d6c8;
            --muted: #8a8a9a;
        }

        body {
            font-family: 'Lato', sans-serif;
            background: var(--primary);
            color: var(--text);
            min-height: 100vh;
        }

        .top-bar {
            background: var(--secondary);
            border-bottom: 2px solid var(--accent);
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-family: 'Cinzel', serif;
            color: var(--accent);
            font-size: 1rem;
            font-weight: 700;
        }


        /*   NAV LINKs*/

        .nav-links {
            display: flex;
            gap: 0.25rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--cream-dim);
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--gold);
            background: rgba(201, 168, 76, 0.08);
        }

        /* */

        .user-info {
            color: var(--muted);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-logout {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            font-size: 0.8rem;
            padding: 4px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: var(--accent);
            color: var(--primary);
        }

        .main {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .page-title {
            font-family: 'Cinzel', serif;
            color: var(--accent);
            font-size: 1.3rem;
            border-bottom: 1px solid rgba(201, 168, 76, 0.3);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-card {
            background: var(--secondary);
            border: 1px solid rgba(201, 168, 76, 0.15);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .section-header {
            background: var(--primary);
            color: var(--accent);
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            padding: 0.75rem 1.2rem;
            border-radius: 8px 8px 0 0;
            border-bottom: 1px solid rgba(201, 168, 76, 0.15);
        }

        .table {
            color: var(--text);
        }

        .table thead th {
            background: var(--primary);
            color: var(--accent);
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            border: none;
        }

        .table tbody tr:hover {
            background: rgba(201, 168, 76, 0.05);
        }

        .info-table th {
            color: var(--muted);
            font-weight: 400;
            font-size: 0.85rem;
            width: 40%;
        }

        .info-table td {
            color: var(--text);
            font-size: 0.85rem;
        }

        .badge-pendiente {
            background: #ffc107;
            color: #000;
        }

        .badge-vencida {
            background: #dc3545;
        }

        .badge-pagada {
            background: #198754;
        }

        .badge-activo {
            background: #198754;
        }

        .badge-pagado {
            background: #198754;
        }

        .badge-cancelado {
            background: #6c757d;
        }

        .badge-vencido {
            background: #dc3545;
        }

        .btn-gold {
            background: var(--accent);
            border: none;
            color: var(--primary);
            font-weight: 700;
            padding: 0.4rem 1rem;
            border-radius: 4px;
            font-size: 0.82rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-gold:hover {
            background: var(--accent-hover);
            color: var(--primary);
        }

        .btn-back {
            background: transparent;
            border: 1px solid rgba(201, 168, 76, 0.3);
            color: var(--muted);
            font-size: 0.82rem;
            padding: 0.4rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .saldo-pendiente {
            color: #dc3545;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .saldo-pagado {
            color: #198754;
            font-weight: 700;
        }


        /* Fix filas blancas Bootstrap 5 */
        .table> :not(caption)>*>* {
            background-color: transparent;
            color: var(--text);
            border-bottom-color: rgba(201, 168, 76, 0.1);
        }

        .table tbody tr {
            background: var(--secondary);
        }

        .table tbody tr:hover>* {
            background-color: rgba(201, 168, 76, 0.05) !important;
            color: var(--text) !important;
        }
    </style>
</head>

<body>

    <div class="top-bar">
        <div class="brand"><i class="bi bi-building me-2"></i>El Sepulturero Juan</div>


        <div class="nav-links">
            <a href="{{ route('home') }}#inicio">Inicio</a>
            <a href="{{ route('cliente.dashboard') }}">Dashboard</a>

            <!--falta contrato-->


            <a href="{{ route('cliente.cuotas') }}">Cuotas</a>


        </div>
        <div class="user-info">
            <span><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->cliente->nombre }} {{ auth()->user()->cliente->paterno }}</span>
            <form method="POST" action="{{ route('cliente.logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i>Salir</button>
            </form>
        </div>
    </div>

    <div class="main">
        <div class="page-title">
            <span><i class="bi bi-file-earmark-text me-2"></i>Contrato #{{ $contrato->id }}</span>
            <a href="{{ route('cliente.dashboard') }}" class="btn-back">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>

        <div class="row g-3">
            {{-- Info contrato --}}
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header"><i class="bi bi-info-circle me-1"></i>Datos del Contrato</div>
                    <div class="p-3">
                        <table class="table table-sm table-borderless info-table mb-0">
                            <tr>
                                <th>Fecha</th>
                                <td>{{ $contrato->fecha_contrato->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Monto Base</th>
                                <td>{{ number_format($contrato->monto_base, 2) }} {{ $contrato->moneda }}</td>
                            </tr>
                            <tr>
                                <th>Saldo Pendiente</th>
                                <td>
                                    @if($contrato->saldo_pendiente > 0)
                                    <span class="saldo-pendiente">{{ number_format($contrato->saldo_pendiente, 2) }} {{ $contrato->moneda }}</span>
                                    @else
                                    <span class="saldo-pagado"><i class="bi bi-check-circle me-1"></i>PAGADO</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td><span class="badge badge-{{ $contrato->estado }}">{{ ucfirst($contrato->estado) }}</span></td>
                            </tr>
                            @if($contrato->observacion)
                            <tr>
                                <th>Observación</th>
                                <td>{{ $contrato->observacion }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            {{-- Info espacio --}}
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header"><i class="bi bi-grid-3x3-gap me-1"></i>Espacio Asignado</div>
                    <div class="p-3">
                        <table class="table table-sm table-borderless info-table mb-0">
                            <tr>
                                <th>Cementerio</th>
                                <td>{{ $contrato->espacio->cementerio->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Tipo</th>
                                <td>{{ $contrato->espacio->tipoInhumacion->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Sección</th>
                                <td>{{ $contrato->espacio->direccion->seccion ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Fila / Número</th>
                                <td>{{ $contrato->espacio->direccion->fila ?? '—' }} / {{ $contrato->espacio->direccion->numero ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Dimensión</th>
                                <td>{{ $contrato->espacio->dimension->ancho }}m × {{ $contrato->espacio->dimension->largo }}m</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td><span class="badge badge-{{ $contrato->espacio->estado }}">{{ ucfirst($contrato->espacio->estado) }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Inhumaciones --}}
            @if($contrato->inhumaciones->count() > 0)
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header"><i class="bi bi-flower1 me-1"></i>Inhumaciones ({{ $contrato->inhumaciones->count() }})</div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>F. Nacimiento</th>
                                    <th>F. Defunción</th>
                                    <th>F. Inhumación</th>
                                    <th>Causa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contrato->inhumaciones as $inh)
                                <tr>
                                    <td>{{ $inh->nombre }} {{ $inh->paterno }} {{ $inh->materno }}</td>
                                    <td>{{ $inh->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</td>
                                    <td>{{ $inh->fecha_defuncion->format('d/m/Y') }}</td>
                                    <td>{{ $inh->fecha_inhumacion->format('d/m/Y') }}</td>
                                    <td>{{ $inh->causa_muerte ?? '—' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Plan de pagos --}}
            @if($contrato->venta?->pagoCredito?->planPago)
            @php $plan = $contrato->venta->pagoCredito->planPago; @endphp
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-calendar-check me-1"></i>Plan de Pagos</span>
                        <small style="color:var(--muted);">
                            {{ ucfirst($plan->frecuencia) }} |
                            Interés: {{ $contrato->venta->pagoCredito->interes }}% |
                            {{ $plan->cuotas->count() }} cuotas de {{ number_format($plan->monto, 2) }} {{ $contrato->moneda }}
                        </small>
                    </div>
                    <div class="table-responsive" style="max-height:350px; overflow-y:auto;">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Cuota</th>
                                    <th>Vencimiento</th>
                                    <th>Monto</th>
                                    <th>Pagado</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plan->cuotas as $cuota)
                                <tr class="{{ $cuota->estado == 'vencida' ? 'table-danger' : ($cuota->estado == 'pagada' ? '' : '') }}"
                                    style="{{ $cuota->estado == 'vencida' ? 'background:rgba(220,53,69,0.1);' : ($cuota->estado == 'pagada' ? 'background:rgba(25,135,84,0.08);' : '') }}">
                                    <td>#{{ $cuota->nro_cuota }}</td>
                                    <td>
                                        {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                                        @if($cuota->fecha_vencimiento->isPast() && $cuota->estado != 'pagada')
                                        <br><small class="text-danger">{{ $cuota->fecha_vencimiento->diffForHumans() }}</small>
                                        @endif
                                    </td>
                                    <td>{{ number_format($cuota->monto, 2) }}</td>
                                    <td>
                                        @if($cuota->pagos->sum('monto_pagado') > 0)
                                        {{ number_format($cuota->pagos->sum('monto_pagado'), 2) }}
                                        @else
                                        <span style="color:var(--muted);">—</span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-{{ $cuota->estado }}">{{ ucfirst($cuota->estado) }}</span></td>
                                    <td>
                                        @if($cuota->estado != 'pagada')
                                        <a href="{{ route('cliente.pagar', $cuota->id) }}" class="btn-gold" style="font-size:0.75rem; padding:3px 10px;">
                                            <i class="bi bi-credit-card me-1"></i>Pagar
                                        </a>
                                        @else
                                        <span style="color:#198754; font-size:0.8rem;"><i class="bi bi-check-circle me-1"></i>Pagada</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Venta contado --}}
            @if($contrato->venta?->pagoContado)
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header"><i class="bi bi-cash me-1"></i>Pago al Contado</div>
                    <div class="p-3">
                        <table class="table table-sm table-borderless info-table mb-0">
                            <tr>
                                <th>Método</th>
                                <td>{{ ucfirst($contrato->venta->pagoContado->metodo_pago) }}</td>
                            </tr>
                            <tr>
                                <th>Total Pagado</th>
                                <td class="saldo-pagado">
                                    {{ number_format($contrato->venta->precio_total - $contrato->venta->pagoContado->descuento, 2) }}
                                    {{ $contrato->moneda }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>