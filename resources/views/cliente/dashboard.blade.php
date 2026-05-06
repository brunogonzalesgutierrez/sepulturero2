<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portal — El Sepulturero Juan</title>
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
        }

        .stat-card {
            background: var(--secondary);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-left: 4px solid var(--accent);
            border-radius: 8px;
            padding: 1.2rem;
        }

        .stat-num {
            font-family: 'Cinzel', serif;
            font-size: 1.8rem;
            color: var(--accent);
        }

        .stat-label {
            color: var(--muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
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

        .btn-gold {
            background: var(--accent);
            border: none;
            color: var(--primary);
            font-weight: 700;
            padding: 0.4rem 1rem;
            border-radius: 4px;
            font-size: 0.82rem;
            transition: all 0.2s;
        }

        .btn-gold:hover {
            background: var(--accent-hover);
            color: var(--primary);
        }

        .nav-tabs .nav-link {
            color: var(--muted);
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: var(--accent);
            background: transparent;
            border-bottom: 2px solid var(--accent);
        }

        /* Fix filas blancas de tabla */
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
            color: var(--text);
        }

        /* Fix fila roja de cuotas vencidas */
        .table-danger>* {
            background-color: rgba(220, 53, 69, 0.15) !important;
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
            <span><i class="bi bi-person-circle me-1"></i>{{ $cliente->nombre }} {{ $cliente->paterno }}</span>
            <form method="POST" action="{{ route('cliente.logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i>Salir</button>
            </form>
        </div>
    </div>

    <div class="main">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2" style="font-size:0.88rem;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <h1 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Mi Portal</h1>

        {{-- Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-num">{{ $contratos->count() }}</div>
                    <div class="stat-label">Contratos</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-num">{{ $cuotasPendientes->count() }}</div>
                    <div class="stat-label">Cuotas Pendientes</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="border-left-color:#dc3545;">
                    <div class="stat-num" style="color:#dc3545; font-size:1.4rem;">
                        {{ number_format($totalPendiente, 2) }}
                    </div>
                    <div class="stat-label">Saldo Pendiente</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="border-left-color:#198754;">
                    <div class="stat-num" style="color:#198754;">
                        {{ $contratos->where('estado','pagado')->count() }}
                    </div>
                    <div class="stat-label">Contratos Pagados</div>
                </div>
            </div>
        </div>

        {{-- Contratos --}}
        <div class="section-card mb-4">
            <div class="section-header"><i class="bi bi-file-earmark-text me-1"></i>Mis Contratos</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Espacio</th>
                            <th>Monto</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contratos as $c)
                        <tr>
                            <td class="text-muted">{{ $c->id }}</td>
                            <td>
                                {{ $c->espacio->cementerio->nombre }}<br>
                                <small class="text-muted">{{ $c->espacio->tipoInhumacion->nombre }}</small>
                            </td>
                            <td>{{ number_format($c->monto_base, 2) }} {{ $c->moneda }}</td>
                            <td>
                                @if($c->saldo_pendiente > 0)
                                <span class="text-danger fw-bold">{{ number_format($c->saldo_pendiente, 2) }}</span>
                                @else
                                <span class="text-success">Pagado</span>
                                @endif
                            </td>
                            <td><span class="badge badge-{{ $c->estado }}">{{ ucfirst($c->estado) }}</span></td>
                            <td>
                                <a href="{{ route('cliente.contrato', $c->id) }}" class="btn-gold">
                                    <i class="bi bi-eye me-1"></i>Ver
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No tiene contratos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Cuotas pendientes --}}
        <div class="section-card">
            <div class="section-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check me-1"></i>Cuotas Pendientes</span>
                <a href="{{ route('cliente.cuotas') }}" style="color:var(--accent); font-size:0.8rem;">Ver todas</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Cuota</th>
                            <th>Vencimiento</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuotasPendientes->take(5) as $cuota)
                        <tr class="{{ $cuota->estado == 'vencida' ? 'table-danger' : '' }}">
                            <td>#{{ $cuota->nro_cuota }}</td>
                            <td>
                                {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                                @if($cuota->fecha_vencimiento->isPast())
                                <br><small class="text-danger">{{ $cuota->fecha_vencimiento->diffForHumans() }}</small>
                                @endif
                            </td>
                            <td>{{ number_format($cuota->monto, 2) }}</td>
                            <td><span class="badge badge-{{ $cuota->estado }}">{{ ucfirst($cuota->estado) }}</span></td>
                            <td>
                                <button class="btn-gold" disabled>
                                    <i class="bi bi-credit-card me-1"></i>Pagar
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-success py-3">
                                <i class="bi bi-check-circle me-1"></i>No tiene cuotas pendientes.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>