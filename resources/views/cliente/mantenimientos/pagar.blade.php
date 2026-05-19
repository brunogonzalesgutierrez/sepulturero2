<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Mantenimiento — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#1a1a2e; --secondary:#16213e; --accent:#c9a84c; --text:#e0d6c8; --muted:#8a8a9a; }
        body { font-family:'Lato',sans-serif; background:var(--primary); color:var(--text); min-height:100vh; display:flex; flex-direction:column; }
        .top-bar { background:var(--secondary); border-bottom:2px solid var(--accent); padding:0.8rem 1.5rem; display:flex; justify-content:space-between; align-items:center; }
        .brand { font-family:'Cinzel',serif; color:var(--accent); font-size:1rem; font-weight:700; }
        .main { max-width:560px; margin:3rem auto; padding:0 1.5rem; width:100%; }
        .page-title { font-family:'Cinzel',serif; color:var(--accent); font-size:1.2rem; text-align:center; margin-bottom:2rem; }
        .resumen-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.2); border-radius:10px; padding:1.5rem; margin-bottom:2rem; text-align:center; }
        .monto { font-family:'Cinzel',serif; font-size:2.5rem; color:var(--accent); font-weight:700; }
        .monto-label { color:var(--muted); font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; }
        .info { color:var(--muted); font-size:0.85rem; margin-top:0.5rem; }
        .metodos { display:flex; flex-direction:column; gap:1rem; }
        .metodo-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.2); border-radius:10px; padding:1.5rem; display:flex; align-items:center; justify-content:space-between; transition:all 0.2s; }
        .metodo-card:hover { border-color:var(--accent); transform:translateY(-2px); }
        .metodo-info { display:flex; align-items:center; gap:1rem; }
        .metodo-icon { font-size:2rem; }
        .metodo-nombre { font-family:'Cinzel',serif; color:var(--accent); font-size:0.95rem; }
        .metodo-desc { color:var(--muted); font-size:0.78rem; }
        .btn-pagar { padding:0.6rem 1.5rem; border:none; border-radius:6px; font-weight:700; font-size:0.85rem; cursor:pointer; transition:all 0.2s; }
        .btn-back { display:block; text-align:center; margin-top:1.5rem; color:var(--muted); text-decoration:none; font-size:0.85rem; transition:color 0.2s; }
        .btn-back:hover { color:var(--accent); }
    </style>
</head>
<body>

<div class="top-bar">
    <div class="brand"><i class="bi bi-building me-2"></i>El Sepulturero Juan</div>
    <span style="color:var(--muted); font-size:0.85rem;">
        <i class="bi bi-person-circle me-1"></i>
        {{ $cliente->nombre }} {{ $cliente->paterno }}
    </span>
</div>

<div class="main">
    <h1 class="page-title"><i class="bi bi-tools me-2"></i>Pagar Mantenimiento</h1>

    @if(session('error'))
    <div style="background:rgba(220,53,69,0.15); border:1px solid rgba(220,53,69,0.4); border-radius:8px; padding:0.75rem 1rem; margin-bottom:1.5rem; color:#ff6b6b; font-size:0.85rem; text-align:center;">
        {{ session('error') }}
    </div>
    @endif

    {{-- Resumen --}}
    <div class="resumen-card">
        <div class="monto-label">Servicio</div>
        <div style="font-family:'Cinzel',serif; color:var(--accent); font-size:1.2rem; margin:0.5rem 0;">
            {{ $venta->tipoMantenimiento->nombre ?? '—' }}
        </div>
        <div class="monto-label" style="margin-top:1rem;">Monto a pagar</div>
        <div class="monto">{{ number_format($venta->precio, 2) }} BOB</div>
        <div class="info">
            {{ $venta->espacio->cementerio->nombre ?? '—' }}<br>
            Fecha solicitud: {{ $venta->fecha_solicitud->format('d/m/Y') }}
        </div>
    </div>

    {{-- Métodos --}}
    <div class="metodos">
        {{-- Libélula --}}
        <div class="metodo-card">
            <div class="metodo-info">
                <div class="metodo-icon">🦋</div>
                <div>
                    <div class="metodo-nombre">Libélula</div>
                    <div class="metodo-desc">QR Simple, Tigo Money, Tarjeta, BCP — en bolivianos</div>
                </div>
            </div>
            <form method="POST" action="{{ route('cliente.libelula.mantenimiento.pagar', $venta->id) }}">
                @csrf
                <button type="submit" class="btn-pagar" style="background:#6b21a8; color:#fff;">
                    Generar QR de pago
                </button>
            </form>
        </div>
    </div>

    <a href="{{ route('cliente.mantenimientos.index') }}" class="btn-back">
        <i class="bi bi-arrow-left me-1"></i>Volver a mis mantenimientos
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>