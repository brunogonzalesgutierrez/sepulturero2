<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Mantenimientos — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#1a1a2e; --secondary:#16213e; --accent:#c9a84c; --accent-hover:#e8c96a; --text:#e0d6c8; --muted:#8a8a9a; }
        body { font-family:'Lato',sans-serif; background:var(--primary); color:var(--text); min-height:100vh; }
        .top-bar { background:var(--secondary); border-bottom:2px solid var(--accent); padding:0.8rem 1.5rem; display:flex; justify-content:space-between; align-items:center; }
        .brand { font-family:'Cinzel',serif; color:var(--accent); font-size:1rem; font-weight:700; }
        .nav-links { display:flex; gap:0.25rem; align-items:center; }
        .nav-links a { text-decoration:none; color:var(--muted); font-size:0.72rem; font-weight:500; letter-spacing:1.5px; text-transform:uppercase; padding:0.4rem 0.8rem; border-radius:4px; transition:all 0.2s; }
        .nav-links a:hover { color:var(--accent); background:rgba(201,168,76,0.08); }
        .user-info { color:var(--muted); font-size:0.85rem; display:flex; align-items:center; gap:1rem; }
        .btn-logout { background:transparent; border:1px solid var(--accent); color:var(--accent); font-size:0.8rem; padding:4px 12px; border-radius:4px; cursor:pointer; transition:all 0.2s; }
        .btn-logout:hover { background:var(--accent); color:var(--primary); }
        .main { max-width:1000px; margin:0 auto; padding:2rem 1.5rem; }
        .page-title { font-family:'Cinzel',serif; color:var(--accent); font-size:1.3rem; border-bottom:1px solid rgba(201,168,76,0.3); padding-bottom:0.75rem; margin-bottom:1.5rem; }
        .section-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.15); border-radius:8px; margin-bottom:1.5rem; }
        .section-header { background:var(--primary); color:var(--accent); font-family:'Cinzel',serif; font-size:0.9rem; padding:0.75rem 1.2rem; border-radius:8px 8px 0 0; border-bottom:1px solid rgba(201,168,76,0.15); display:flex; justify-content:space-between; align-items:center; }
        .table { color:var(--text); }
        .table thead th { background:var(--primary); color:var(--accent); font-family:'Cinzel',serif; font-size:0.75rem; border:none; }
        .table>:not(caption)>*>* { background-color:transparent; color:var(--text); border-bottom-color:rgba(201,168,76,0.1); }
        .table tbody tr { background:var(--secondary); }
        .table tbody tr:hover>* { background-color:rgba(201,168,76,0.05) !important; }
        .btn-gold { background:var(--accent); border:none; color:var(--primary); font-weight:700; padding:0.4rem 1rem; border-radius:4px; font-size:0.82rem; transition:all 0.2s; text-decoration:none; display:inline-block; }
        .btn-gold:hover { background:var(--accent-hover); color:var(--primary); }
        .btn-pagar { background:var(--accent); color:var(--primary); font-weight:700; padding:3px 12px; border-radius:4px; font-size:0.78rem; text-decoration:none; display:inline-block; transition:all 0.2s; }
        .btn-pagar:hover { background:var(--accent-hover); color:var(--primary); }
        .badge-tipo { background:rgba(201,168,76,0.15); color:var(--accent); padding:2px 8px; border-radius:4px; font-size:0.8rem; }
        .badge-pendiente { background:#ffc107; color:#000; padding:2px 8px; border-radius:4px; font-size:0.8rem; }
        .badge-pagado { background:#198754; color:#fff; padding:2px 8px; border-radius:4px; font-size:0.8rem; }
    </style>
</head>
<body>

<div class="top-bar">
    <div class="brand"><i class="bi bi-building me-2"></i>El Sepulturero Juan</div>
    <div class="nav-links">
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('cliente.dashboard') }}">Dashboard</a>
        <a href="{{ route('cliente.cuotas') }}">Cuotas</a>
        <a href="{{ route('cliente.mantenimientos.index') }}">Mantenimientos</a>
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
        <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show py-2" style="font-size:0.88rem;">
        <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <h1 class="page-title"><i class="bi bi-tools me-2"></i>Mis Mantenimientos</h1>

    <div class="section-card">
        <div class="section-header">
            <span><i class="bi bi-list-check me-1"></i>Historial de Solicitudes</span>
            <a href="{{ route('cliente.mantenimientos.create') }}" class="btn-gold">
                <i class="bi bi-plus-lg me-1"></i>Solicitar Mantenimiento
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Espacio</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Estado Pago</th>
                        <th>Estado Servicio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $v)
                    <tr>
                        <td class="text-muted" style="font-size:0.8rem;">{{ $v->id }}</td>
                        <td>
                            <span class="badge-tipo">
                                {{ $v->tipoMantenimiento->nombre ?? '—' }}
                            </span>
                        </td>
                        <td>
                            {{ $v->espacio->cementerio->nombre ?? '—' }}<br>
                            <small style="color:var(--muted);">
                                Secc: {{ $v->espacio->direccion->seccion ?? '?' }} /
                                Nro: {{ $v->espacio->direccion->numero ?? '?' }}
                            </small>
                        </td>
                        <td>{{ number_format($v->precio, 2) }} BOB</td>
                        <td>{{ $v->fecha_solicitud->format('d/m/Y') }}</td>
                        <td>
                            @if($v->estado_pago === 'pagado')
                                <span class="badge-pagado">Pagado</span>
                            @else
                                <span class="badge-pendiente">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            <span style="background:rgba(201,168,76,0.1); color:var(--muted); padding:2px 8px; border-radius:4px; font-size:0.8rem;">
                                {{ ucfirst(str_replace('_', ' ', $v->estado_pago)) }}
                            </span>
                        </td>
                        <td>
                            @if($v->estado_pago === 'pendiente')
                                <a href="{{ route('cliente.mantenimientos.pagar', $v->id) }}" class="btn-pagar">
                                    <i class="bi bi-credit-card me-1"></i>Pagar
                                </a>
                            @else
                                <span style="color:#198754; font-size:0.8rem;">
                                    <i class="bi bi-check-circle me-1"></i>Pagado
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4" style="color:var(--muted);">
                            <i class="bi bi-inbox d-block mb-2" style="font-size:1.5rem;"></i>
                            No tiene solicitudes de mantenimiento aún.
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