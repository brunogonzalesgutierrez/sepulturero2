<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Mantenimiento — El Sepulturero Juan</title>
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
        .main { max-width:680px; margin:0 auto; padding:2rem 1.5rem; }
        .page-title { font-family:'Cinzel',serif; color:var(--accent); font-size:1.3rem; border-bottom:1px solid rgba(201,168,76,0.3); padding-bottom:0.75rem; margin-bottom:1.5rem; }
        .portal-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.2); border-radius:10px; padding:1.5rem; }
        .form-label { color:var(--accent); font-size:0.8rem; letter-spacing:1px; text-transform:uppercase; }
        .form-control, .form-select { background:var(--primary); border:1px solid rgba(201,168,76,0.2); color:var(--text); border-radius:6px; }
        .form-control:focus, .form-select:focus { background:var(--primary); border-color:var(--accent); color:var(--text); box-shadow:0 0 0 0.2rem rgba(201,168,76,0.15); }
        .form-select option { background:var(--primary); }
        .btn-gold { background:var(--accent); border:none; color:var(--primary); font-weight:700; padding:0.6rem 1.5rem; border-radius:6px; font-size:0.85rem; transition:all 0.2s; width:100%; }
        .btn-gold:hover { background:var(--accent-hover); color:var(--primary); }
        .preview-box { background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.2); border-radius:8px; padding:1rem 1.2rem; margin-top:1rem; display:none; }
        .preview-precio { font-family:'Cinzel',serif; font-size:2rem; color:var(--accent); }
        .preview-label { color:var(--muted); font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; }
        .no-espacios { background:rgba(220,53,69,0.1); border:1px solid rgba(220,53,69,0.3); border-radius:8px; padding:1rem; color:#ff6b6b; font-size:0.88rem; text-align:center; }
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
    <h1 class="page-title"><i class="bi bi-plus-circle me-2"></i>Solicitar Mantenimiento</h1>

    @if($errors->any())
    <div class="alert alert-danger py-2 mb-3" style="font-size:0.85rem;">
        {{ $errors->first() }}
    </div>
    @endif

    @if($espacios->isEmpty())
    <div class="no-espacios">
        <i class="bi bi-exclamation-triangle me-2"></i>
        No tiene espacios con contrato activo. Contacte a la administración.
    </div>
    @else
    <div class="portal-card">
        <form method="POST" action="{{ route('cliente.mantenimientos.store') }}">
            @csrf

            {{-- Paso 1: Elegir espacio --}}
            <div class="mb-3">
                <label class="form-label">1. Seleccione su espacio <span class="text-danger">*</span></label>
                <select name="espacio_id" id="espacio_id" class="form-select" required>
                    <option value="">Seleccione un espacio...</option>
                    @foreach($espacios as $e)
                    <option value="{{ $e->id }}">
                        {{ $e->cementerio->nombre }} —
                        {{ $e->tipoInhumacion->nombre }} |
                        Secc: {{ $e->direccion->seccion ?? '?' }}
                        Fila: {{ $e->direccion->fila ?? '?' }}
                        Nro: {{ $e->direccion->numero ?? '?' }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Paso 2: Elegir tipo de mantenimiento --}}
            <div class="mb-3">
                <label class="form-label">2. Tipo de mantenimiento <span class="text-danger">*</span></label>
                <select name="tipo_mantenimiento_id" id="tipo_id" class="form-select" required>
                    <option value="">Seleccione un tipo...</option>
                    @foreach($tipos as $t)
                    <option value="{{ $t->id }}"
                        data-precio="{{ $t->precio_base }}"
                        data-desc="{{ $t->descripcion }}">
                        {{ $t->nombre }} — {{ number_format($t->precio_base, 2) }} BOB
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Preview precio --}}
            <div class="preview-box" id="preview">
                <div class="preview-label">Precio del servicio</div>
                <div class="preview-precio" id="prev-precio">—</div>
                <div style="color:var(--muted); font-size:0.82rem; margin-top:0.3rem;" id="prev-desc">—</div>
            </div>

            {{-- Observación --}}
            <div class="mb-3 mt-3">
                <label class="form-label">3. Observación (opcional)</label>
                <textarea name="observacion" rows="3" class="form-control"
                    placeholder="Indique algún detalle adicional sobre el servicio que necesita...">{{ old('observacion') }}</textarea>
            </div>

            <button type="submit" class="btn-gold">
                <i class="bi bi-send me-2"></i>Enviar Solicitud
            </button>
        </form>
    </div>
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('cliente.mantenimientos.index') }}"
            style="color:var(--muted); text-decoration:none; font-size:0.85rem;">
            <i class="bi bi-arrow-left me-1"></i>Volver a mis mantenimientos
        </a>
    </div>
</div>

<script>
document.getElementById('tipo_id').addEventListener('change', function () {
    const opt  = this.options[this.selectedIndex];
    const precio = opt.dataset.precio;
    const desc   = opt.dataset.desc;
    const preview = document.getElementById('preview');

    if (precio) {
        document.getElementById('prev-precio').textContent = parseFloat(precio).toFixed(2) + ' BOB';
        document.getElementById('prev-desc').textContent   = desc || '';
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>