<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con QR — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#1a1a2e; --secondary:#16213e; --accent:#c9a84c; --accent-hover:#e8c96a; --text:#e0d6c8; --muted:#8a8a9a; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Lato',sans-serif; background:var(--primary); color:var(--text); min-height:100vh; display:flex; flex-direction:column; }

        .top-bar { background:var(--secondary); border-bottom:2px solid var(--accent); padding:0.8rem 1.5rem; display:flex; justify-content:space-between; align-items:center; }
        .brand { font-family:'Cinzel',serif; color:var(--accent); font-size:1rem; font-weight:700; }

        .main { max-width:900px; margin:2rem auto; padding:0 1.5rem; width:100%; flex:1; }

        .page-title { font-family:'Cinzel',serif; color:var(--accent); font-size:1.2rem; border-bottom:1px solid rgba(201,168,76,0.3); padding-bottom:0.75rem; margin-bottom:1.5rem; display:flex; justify-content:space-between; align-items:center; }

        .btn-back { background:transparent; border:1px solid rgba(201,168,76,0.3); color:var(--muted); font-size:0.82rem; padding:0.4rem 1rem; border-radius:4px; text-decoration:none; transition:all 0.2s; }
        .btn-back:hover { border-color:var(--accent); color:var(--accent); }

        .layout { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }

        /* Panel izquierdo — detalles */
        .detalles-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.15); border-radius:12px; padding:1.5rem; }
        .detalles-title { font-family:'Cinzel',serif; color:var(--accent); font-size:0.9rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem; }
        .info-row { display:flex; justify-content:space-between; align-items:center; padding:0.6rem 0; border-bottom:1px solid rgba(201,168,76,0.08); font-size:0.85rem; }
        .info-row:last-child { border-bottom:none; }
        .info-label { color:var(--muted); }
        .info-value { color:var(--text); font-weight:500; }
        .monto-grande { font-family:'Cinzel',serif; font-size:2rem; color:var(--accent); font-weight:700; text-align:center; margin:1rem 0; }
        .badge-vencida { background:#dc3545; color:#fff; font-size:0.7rem; padding:2px 8px; border-radius:20px; }
        .badge-pendiente { background:#ffc107; color:#000; font-size:0.7rem; padding:2px 8px; border-radius:20px; }

        /* Panel derecho — QR */
        .qr-card { background:var(--secondary); border:1px solid rgba(201,168,76,0.3); border-radius:12px; padding:1.5rem; display:flex; flex-direction:column; align-items:center; text-align:center; }
        .qr-title { font-family:'Cinzel',serif; color:var(--accent); font-size:0.9rem; margin-bottom:1rem; }
        .qr-wrapper { background:#fff; padding:1rem; border-radius:10px; margin-bottom:1rem; }
        .qr-wrapper img { width:220px; height:220px; display:block; }
        .qr-instrucciones { color:var(--muted); font-size:0.78rem; line-height:1.6; margin-bottom:1.2rem; }
        .qr-instrucciones span { color:var(--accent); }

        /* Estado del pago */
        .estado-verificando { color:var(--muted); font-size:0.82rem; display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem; }
        .estado-pagado { color:#198754; font-size:0.9rem; font-weight:700; display:none; align-items:center; gap:0.5rem; margin-bottom:1rem; }
        .spinner { width:16px; height:16px; border:2px solid rgba(201,168,76,0.3); border-top-color:var(--accent); border-radius:50%; animation:spin 1s linear infinite; }
        @keyframes spin { to { transform:rotate(360deg); } }

        /* Barra de progreso verificación */
        .verificacion-bar { width:100%; height:3px; background:rgba(201,168,76,0.15); border-radius:2px; overflow:hidden; margin-bottom:1rem; }
        .verificacion-progress { height:100%; background:var(--accent); border-radius:2px; width:0%; transition:width 5s linear; }

        /* Botón pasarela completa */
        .btn-pasarela { background:transparent; border:1px solid rgba(201,168,76,0.25); color:var(--muted); font-size:0.78rem; padding:0.5rem 1rem; border-radius:6px; text-decoration:none; transition:all 0.2s; display:inline-flex; align-items:center; gap:0.4rem; }
        .btn-pasarela:hover { border-color:var(--accent); color:var(--accent); }

        /* Overlay de éxito */
        .success-overlay { display:none; position:fixed; inset:0; background:rgba(10,10,20,0.92); z-index:100; flex-direction:column; align-items:center; justify-content:center; text-align:center; }
        .success-overlay.show { display:flex; }
        .success-icon { font-size:4rem; color:#198754; margin-bottom:1rem; animation:popIn 0.4s ease; }
        .success-title { font-family:'Cinzel',serif; color:var(--accent); font-size:1.5rem; margin-bottom:0.5rem; }
        .success-sub { color:var(--muted); font-size:0.9rem; margin-bottom:1.5rem; }
        .btn-gold { background:var(--accent); border:none; color:var(--primary); font-weight:700; padding:0.6rem 1.5rem; border-radius:6px; text-decoration:none; transition:all 0.2s; font-size:0.9rem; }
        .btn-gold:hover { background:var(--accent-hover); color:var(--primary); }
        @keyframes popIn { from { transform:scale(0.5); opacity:0; } to { transform:scale(1); opacity:1; } }

        @media(max-width:640px) {
            .layout { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <div class="brand"><i class="bi bi-building me-2"></i>El Sepulturero Juan</div>
    <span style="color:var(--muted); font-size:0.85rem;">
        <i class="bi bi-person-circle me-1"></i>
        {{ auth()->user()->cliente->nombre }} {{ auth()->user()->cliente->paterno }}
    </span>
</div>

<div class="main">
    <div class="page-title">
        <span><i class="bi bi-qr-code me-2"></i>Pago con QR — Libélula</span>
        <a href="{{ route('cliente.pagar', $cuota->id) }}" class="btn-back">
            <i class="bi bi-arrow-left me-1"></i>Volver
        </a>
    </div>

    <div class="layout">

        {{-- Panel izquierdo: detalles --}}
        <div class="detalles-card">
            <div class="detalles-title">
                <i class="bi bi-receipt"></i> Detalle del Pago
            </div>

            <div class="monto-grande">
                {{ number_format($cuota->monto, 2) }} {{ $contrato->moneda }}
            </div>

            <div class="info-row">
                <span class="info-label">Concepto</span>
                <span class="info-value">Cuota #{{ $cuota->nro_cuota }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cementerio</span>
                <span class="info-value">{{ $contrato->espacio->cementerio->nombre }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Contrato</span>
                <span class="info-value">#{{ $contrato->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Vencimiento</span>
                <span class="info-value">
                    {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                    @if($cuota->estado === 'vencida')
                        <span class="badge-vencida ms-1">Vencida</span>
                    @else
                        <span class="badge-pendiente ms-1">Pendiente</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Cliente</span>
                <span class="info-value">{{ auth()->user()->cliente->nombre }} {{ auth()->user()->cliente->paterno }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">CI</span>
                <span class="info-value">{{ auth()->user()->cliente->ci }}</span>
            </div>

            <div style="margin-top:1.5rem; padding:0.75rem; background:rgba(201,168,76,0.08); border-radius:8px; border-left:3px solid var(--accent);">
                <div style="font-size:0.75rem; color:var(--muted); line-height:1.6;">
                    <i class="bi bi-shield-check me-1" style="color:var(--accent);"></i>
                    Pago procesado de forma segura a través de <strong style="color:var(--accent);">Libélula</strong> — plataforma boliviana de pagos.
                </div>
            </div>
        </div>

        {{-- Panel derecho: QR --}}
        <div class="qr-card">
            <div class="qr-title">
                <i class="bi bi-qr-code me-1"></i> Código QR-Simple
            </div>

            <div class="qr-wrapper">
                <img src="{{ $qrUrl }}" alt="QR de pago" id="qrImage">
            </div>

            <div class="qr-instrucciones">
                1. Abre la app de tu banco (<span>BCP</span>, <span>BNB</span>, u otro)<br>
                2. Selecciona <span>QR-Simple</span> o <span>pago con QR</span><br>
                3. Escanea el código<br>
                4. Confirma el pago en tu app
            </div>

            {{-- Estado verificación automática --}}
            <div class="estado-verificando" id="estadoVerificando">
                <div class="spinner"></div>
                Verificando pago automáticamente...
            </div>
            <div class="estado-pagado" id="estadoPagado">
                <i class="bi bi-check-circle-fill"></i>
                ¡Pago confirmado!
            </div>

            <div class="verificacion-bar">
                <div class="verificacion-progress" id="progressBar"></div>
            </div>

            {{-- Enlace a pasarela completa --}}
            @if($pasarela)
            <a href="{{ $pasarela }}" class="btn-pasarela" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                Prefiero pagar con Tigo Money, tarjeta u otro método
            </a>
            @endif
        </div>
    </div>
</div>

{{-- Overlay de éxito --}}
<div class="success-overlay" id="successOverlay">
    <div class="success-icon"><i class="bi bi-check-circle-fill"></i></div>
    <div class="success-title">¡Pago Exitoso!</div>
    <div class="success-sub">
        Tu pago de <strong>{{ number_format($cuota->monto, 2) }} {{ $contrato->moneda }}</strong>
        ha sido confirmado.<br>Serás redirigido en unos segundos.
    </div>
    <a href="{{ route('cliente.cuotas') }}" class="btn-gold">
        <i class="bi bi-check me-1"></i>Ver mis cuotas
    </a>
</div>

<script>
    const verificarUrl  = "{{ route('cliente.libelula.verificar', $cuota->id) }}";
    const cuotasUrl     = "{{ route('cliente.cuotas') }}";
    let intentos        = 0;
    const maxIntentos   = 24; // 2 minutos (cada 5 seg)

    function animarBarra() {
        const bar = document.getElementById('progressBar');
        bar.style.width = '0%';
        setTimeout(() => { bar.style.width = '100%'; }, 100);
        setTimeout(() => { bar.style.width = '0%'; bar.style.transition = 'none'; setTimeout(() => { bar.style.transition = 'width 5s linear'; }, 50); }, 5200);
    }

    function verificarPago() {
        if (intentos >= maxIntentos) {
            document.getElementById('estadoVerificando').innerHTML =
                '<i class="bi bi-clock me-1"></i> Tiempo de espera agotado. ' +
                '<a href="' + verificarUrl + '" style="color:var(--accent);">Verificar manualmente</a>';
            return;
        }

        intentos++;
        animarBarra();

        fetch(verificarUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.pagado) {
                // Mostrar overlay de éxito
                document.getElementById('estadoVerificando').style.display = 'none';
                document.getElementById('estadoPagado').style.display = 'flex';
                document.getElementById('successOverlay').classList.add('show');

                // Redirigir después de 3 segundos
                setTimeout(() => { window.location.href = cuotasUrl; }, 3000);
            } else {
                setTimeout(verificarPago, 5000);
            }
        })
        .catch(() => {
            setTimeout(verificarPago, 5000);
        });
    }

    // Iniciar verificación después de 5 segundos
    setTimeout(verificarPago, 5000);
</script>

</body>
</html>