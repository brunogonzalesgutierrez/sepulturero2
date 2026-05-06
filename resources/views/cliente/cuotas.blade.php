<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cuotas — El Sepulturero Juan</title>
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

        .stat-card {
            background: var(--secondary);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-left: 4px solid var(--accent);
            border-radius: 8px;
            padding: 1rem;
        }

        .stat-num {
            font-family: 'Cinzel', serif;
            font-size: 1.6rem;
            color: var(--accent);
        }

        .stat-label {
            color: var(--muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--muted);
            padding: 0.5rem 1.2rem;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .tab-btn.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .tab-content-panel {
            display: none;
        }

        .tab-content-panel.active {
            display: block;
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
            <span><i class="bi bi-calendar-check me-2"></i>Mis Cuotas</span>
            <a href="{{ route('cliente.dashboard') }}" class="btn-back">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>

        {{-- Resumen --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-num">{{ $cuotas->count() }}</div>
                    <div class="stat-label">Total Cuotas</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="border-left-color:#ffc107;">
                    <div class="stat-num" style="color:#ffc107;">
                        {{ $cuotas->where('estado','pendiente')->count() }}
                    </div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="border-left-color:#dc3545;">
                    <div class="stat-num" style="color:#dc3545;">
                        {{ $cuotas->where('estado','vencida')->count() }}
                    </div>
                    <div class="stat-label">Vencidas</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="border-left-color:#198754;">
                    <div class="stat-num" style="color:#198754;">
                        {{ $cuotas->where('estado','pagada')->count() }}
                    </div>
                    <div class="stat-label">Pagadas</div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div style="border-bottom:1px solid rgba(201,168,76,0.2); margin-bottom:1rem;">
            <button class="tab-btn active" onclick="showTab('pendientes')">
                Pendientes y Vencidas
            </button>
            <button class="tab-btn" onclick="showTab('pagadas')">
                Pagadas
            </button>
            <button class="tab-btn" onclick="showTab('todas')">
                Todas
            </button>
        </div>

        {{-- Tab Pendientes --}}
        <div id="tab-pendientes" class="tab-content-panel active">
            <div class="section-card">
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
                            @forelse($cuotas->whereIn('estado',['pendiente','vencida'])->sortBy('fecha_vencimiento') as $cuota)
                            <tr style="{{ $cuota->estado == 'vencida' ? 'background:rgba(220,53,69,0.08);' : '' }}">
                                <td>#{{ $cuota->nro_cuota }}</td>
                                <td>
                                    {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                                    @if($cuota->fecha_vencimiento->isPast())
                                    <br><small class="text-danger">{{ $cuota->fecha_vencimiento->diffForHumans() }}</small>
                                    @else
                                    <br><small style="color:var(--muted);">{{ $cuota->fecha_vencimiento->diffForHumans() }}</small>
                                    @endif
                                </td>
                                <td><strong>{{ number_format($cuota->monto, 2) }}</strong></td>
                                <td><span class="badge badge-{{ $cuota->estado }}">{{ ucfirst($cuota->estado) }}</span></td>
                                <td>
                                    <a href="{{ route('cliente.pagar', $cuota->id) }}" class="btn-gold" style="font-size:0.78rem; padding:4px 12px;">
                                        <i class="bi bi-credit-card me-1"></i>Pagar Online
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4" style="color:var(--muted);">
                                    <i class="bi bi-check-circle me-1" style="color:#198754;"></i>No tiene cuotas pendientes.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tab Pagadas --}}
        <div id="tab-pagadas" class="tab-content-panel">
            <div class="section-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Cuota</th>
                                <th>Vencimiento</th>
                                <th>Monto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cuotas->where('estado','pagada') as $cuota)
                            <tr style="background:rgba(25,135,84,0.05);">
                                <td>#{{ $cuota->nro_cuota }}</td>
                                <td>{{ $cuota->fecha_vencimiento->format('d/m/Y') }}</td>
                                <td>{{ number_format($cuota->monto, 2) }}</td>
                                <td><span class="badge badge-pagada">Pagada</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4" style="color:var(--muted);">Sin cuotas pagadas aún.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tab Todas --}}
        <div id="tab-todas" class="tab-content-panel">
            <div class="section-card">
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
                            @foreach($cuotas->sortBy('nro_cuota') as $cuota)
                            <tr>
                                <td>#{{ $cuota->nro_cuota }}</td>
                                <td>{{ $cuota->fecha_vencimiento->format('d/m/Y') }}</td>
                                <td>{{ number_format($cuota->monto, 2) }}</td>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab-content-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>

</html>