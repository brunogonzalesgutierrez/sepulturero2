<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Cuota — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #c9a84c;
            --text: #e0d6c8;
            --muted: #8a8a9a;
        }

        body {
            font-family: 'Lato', sans-serif;
            background: var(--primary);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .main {
            max-width: 560px;
            margin: 3rem auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .page-title {
            font-family: 'Cinzel', serif;
            color: var(--accent);
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .resumen-card {
            background: var(--secondary);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .monto {
            font-family: 'Cinzel', serif;
            font-size: 2.5rem;
            color: var(--accent);
            font-weight: 700;
        }

        .monto-label {
            color: var(--muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cuota-info {
            color: var(--muted);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .metodos {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .metodo-card {
            background: var(--secondary);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 10px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s;
        }

        .metodo-card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .metodo-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .metodo-icon {
            font-size: 2rem;
        }

        .metodo-nombre {
            font-family: 'Cinzel', serif;
            color: var(--accent);
            font-size: 0.95rem;
        }

        .metodo-desc {
            color: var(--muted);
            font-size: 0.78rem;
        }

        .btn-pagar {
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .btn-back:hover {
            color: var(--accent);
        }

        .vencida-alert {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.4);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            color: #ff6b6b;
            font-size: 0.85rem;
            text-align: center;
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
        <h1 class="page-title"><i class="bi bi-credit-card me-2"></i>Pagar Cuota</h1>

        @if(session('error'))
        <div class="vencida-alert">{{ session('error') }}</div>
        @endif

        @if($cuota->estado === 'vencida')
        <div class="vencida-alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Esta cuota está vencida desde {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
            ({{ $cuota->fecha_vencimiento->diffForHumans() }})
        </div>
        @endif

        {{-- Resumen de la cuota --}}
        <div class="resumen-card">
            <div class="monto-label">Monto a pagar</div>

            @if($moneda === 'BOB')
            <div class="monto">{{ number_format($montoUsd, 2) }} USD</div>
            <div class="cuota-info">
                {{ number_format($cuota->monto, 2) }} BOB
                <span style="color:var(--accent);">→</span>
                {{ number_format($montoUsd, 2) }} USD
                <br>
                <small>Tasa: 1 BOB = {{ number_format($tasa, 4) }} USD</small>
            </div>
            @else
            <div class="monto">{{ number_format($montoUsd, 2) }} USD</div>
            <div class="cuota-info">Cuota #{{ $cuota->nro_cuota }}</div>
            @endif

            <div class="cuota-info mt-1">
                Vence: {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
            </div>
        </div>

        {{-- Métodos de pago --}}
        <div class="metodos">
            


            {{-- Libélula --}}
            @if(session('libelula_qr'))
            {{-- QR generado — mostrar en tu página --}}
            <div class="metodo-card flex-column align-items-center" style="border-color:var(--accent);">
                <div class="metodo-info mb-3">
                    <div class="metodo-icon">🦋</div>
                    <div>
                        <div class="metodo-nombre">Pagar con QR — Libélula</div>
                        <div class="metodo-desc">Escanea con la app de tu banco (BCP, BNB, etc.)</div>
                    </div>
                </div>

                {{-- QR Image --}}
                <div style="background:#fff; padding:1rem; border-radius:10px; margin-bottom:1rem;">
                    <img src="{{ session('libelula_qr') }}"
                        alt="Código QR de pago"
                        style="width:200px; height:200px; display:block;">
                </div>

                <div style="color:var(--muted); font-size:0.8rem; text-align:center; margin-bottom:1rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    Una vez escaneado y pagado, haz clic en "Confirmar Pago"
                </div>

                {{-- Botón confirmar --}}
                <a href="{{ route('cliente.libelula.retorno', $cuota->id) }}"
                class="btn-pagar"
                style="background:var(--accent); color:var(--primary); text-decoration:none; text-align:center; display:inline-block;">
                    <i class="bi bi-check-circle me-1"></i>Ya pagué — Confirmar
                </a>

                {{-- Enlace a pasarela completa si prefieren otro método --}}
                @if(session('libelula_pasarela'))
                <a href="{{ session('libelula_pasarela') }}"
                style="color:var(--muted); font-size:0.78rem; margin-top:0.75rem; display:block; text-align:center; text-decoration:none;">
                    <i class="bi bi-box-arrow-up-right me-1"></i>
                    Prefiero pagar con Tigo Money, tarjeta u otro método
                </a>
                @endif
            </div>

            @else
            {{-- Botón normal para generar el QR --}}
            <div class="metodo-card">
                <div class="metodo-info">
                    <div class="metodo-icon">🦋</div>
                    <div>
                        <div class="metodo-nombre">Libélula</div>
                        <div class="metodo-desc">QR Simple, Tigo Money, Tarjeta, BCP — en bolivianos</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('cliente.libelula.pagar', $cuota->id) }}">
                    @csrf
                    <button type="submit" class="btn-pagar" style="background:#6b21a8; color:#fff;">
                        Generar QR de pago
                    </button>
                </form>
            </div>
            @endif
        </div>

        <a href="{{ route('cliente.cuotas') }}" class="btn-back">
            <i class="bi bi-arrow-left me-1"></i>Volver a mis cuotas
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>