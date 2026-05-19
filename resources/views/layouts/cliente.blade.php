<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Portal') — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#1a1a2e; --secondary:#16213e; --accent:#c9a84c; --accent-hover:#e8c96a; --text:#e0d6c8; --muted:#8a8a9a; }
        body { font-family:'Lato',sans-serif; background:var(--primary); color:var(--text); min-height:100vh; }

        /* TOP BAR */
        .top-bar { background:var(--secondary); border-bottom:2px solid var(--accent); padding:0.8rem 1.5rem; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:100; }
        .brand { font-family:'Cinzel',serif; color:var(--accent); font-size:1rem; font-weight:700; text-decoration:none; }
        .nav-links { display:flex; gap:0.25rem; align-items:center; }
        .nav-links a { text-decoration:none; color:var(--muted); font-size:0.72rem; font-weight:500; letter-spacing:1.5px; text-transform:uppercase; padding:0.4rem 0.8rem; border-radius:4px; transition:all 0.2s; }
        .nav-links a:hover, .nav-links a.active { color:var(--accent); background:rgba(201,168,76,0.08); }
        .user-info { color:var(--muted); font-size:0.85rem; display:flex; align-items:center; gap:1rem; }
        .btn-logout { background:transparent; border:1px solid var(--accent); color:var(--accent); font-size:0.8rem; padding:4px 12px; border-radius:4px; cursor:pointer; transition:all 0.2s; }
        .btn-logout:hover { background:var(--accent); color:var(--primary); }

        /* MAIN */
        .main { max-width:1000px; margin:0 auto; padding:2rem 1.5rem; }
        .page-title { font-family:'Cinzel',serif; color:var(--accent); font-size:1.3rem; border-bottom:1px solid rgba(201,168,76,0.3); padding-bottom:0.75rem; margin-bottom:1.5rem; }

        /* CARDS */
        .section-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.15); border-radius:8px; margin-bottom:1.5rem; }
        .section-header { background:var(--primary); color:var(--accent); font-family:'Cinzel',serif; font-size:0.9rem; padding:0.75rem 1.2rem; border-radius:8px 8px 0 0; border-bottom:1px solid rgba(201,168,76,0.15); display:flex; justify-content:space-between; align-items:center; }
        .stat-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.2); border-left:4px solid var(--accent); border-radius:8px; padding:1.2rem; }
        .stat-num { font-family:'Cinzel',serif; font-size:1.8rem; color:var(--accent); }
        .stat-label { color:var(--muted); font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; }

        /* TABLE */
        .table { color:var(--text); }
        .table thead th { background:var(--primary); color:var(--accent); font-family:'Cinzel',serif; font-size:0.75rem; border:none; }
        .table>:not(caption)>*>* { background-color:transparent; color:var(--text); border-bottom-color:rgba(201,168,76,0.1); }
        .table tbody tr { background:var(--secondary); }
        .table tbody tr:hover>* { background-color:rgba(201,168,76,0.05) !important; color:var(--text); }
        .table-danger>* { background-color:rgba(220,53,69,0.15) !important; color:var(--text) !important; }

        /* BADGES */
        .badge-pendiente { background:#ffc107; color:#000; padding:2px 8px; border-radius:4px; font-size:0.8rem; }
        .badge-vencida { background:#dc3545; color:#fff; padding:2px 8px; border-radius:4px; font-size:0.8rem; }
        .badge-pagada, .badge-pagado { background:#198754; color:#fff; padding:2px 8px; border-radius:4px; font-size:0.8rem; }
        .badge-activo { background:#198754; color:#fff; padding:2px 8px; border-radius:4px; font-size:0.8rem; }
        .badge-tipo { background:rgba(201,168,76,0.15); color:var(--accent); padding:2px 8px; border-radius:4px; font-size:0.8rem; }

        /* BUTTONS */
        .btn-gold { background:var(--accent); border:none; color:var(--primary); font-weight:700; padding:0.4rem 1rem; border-radius:4px; font-size:0.82rem; transition:all 0.2s; text-decoration:none; display:inline-block; }
        .btn-gold:hover { background:var(--accent-hover); color:var(--primary); }
        .btn-outline-gold { background:transparent; border:1px solid rgba(201,168,76,0.3); color:var(--muted); font-size:0.82rem; padding:0.4rem 1rem; border-radius:4px; text-decoration:none; transition:all 0.2s; display:inline-block; }
        .btn-outline-gold:hover { border-color:var(--accent); color:var(--accent); }

        @yield('styles')
    </style>
</head>
<body>

<div class="top-bar">
    <a href="{{ route('cliente.dashboard') }}" class="brand">
        <i class="bi bi-building me-2"></i>El Sepulturero Juan
    </a>

    <div class="nav-links">
        <a href="{{ route('home') }}"
            class="{{ request()->routeIs('home') ? 'active' : '' }}">
            Inicio
        </a>
        <a href="{{ route('cliente.dashboard') }}"
            class="{{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('cliente.cuotas') }}"
            class="{{ request()->routeIs('cliente.cuotas') ? 'active' : '' }}">
            Cuotas
        </a>
        <a href="{{ route('cliente.mantenimientos.index') }}"
            class="{{ request()->routeIs('cliente.mantenimientos.*') ? 'active' : '' }}">
            Mantenimientos
        </a>
    </div>

    <div class="user-info">
        <span>
            <i class="bi bi-person-circle me-1"></i>
            {{ auth()->user()->cliente->nombre }} {{ auth()->user()->cliente->paterno }}
        </span>
        <form method="POST" action="{{ route('cliente.logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right me-1"></i>Salir
            </button>
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

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>