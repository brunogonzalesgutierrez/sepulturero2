<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación 2FA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#1a1a2e; display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .card { background:#16213e; border:1px solid rgba(201,168,76,0.3); border-radius:12px; padding:2rem; width:100%; max-width:400px; }
        .title { color:#c9a84c; font-size:1.2rem; font-weight:700; text-align:center; margin-bottom:0.5rem; }
        .subtitle { color:#8a8a9a; font-size:0.85rem; text-align:center; margin-bottom:1.5rem; }
        .form-label { color:#c9a84c; font-size:0.78rem; text-transform:uppercase; letter-spacing:1px; }
        .form-control { background:#1a1a2e; border:1px solid rgba(201,168,76,0.3); color:#e0d6c8; text-align:center; font-size:1.5rem; letter-spacing:0.5rem; border-radius:8px; }
        .form-control:focus { background:#1a1a2e; border-color:#c9a84c; color:#e0d6c8; box-shadow:0 0 0 0.2rem rgba(201,168,76,0.15); }
        .btn-gold { background:#c9a84c; border:none; color:#1a1a2e; font-weight:700; width:100%; padding:0.6rem; border-radius:8px; }
        .btn-gold:hover { background:#e8c96a; color:#1a1a2e; }
        .icon { font-size:3rem; text-align:center; margin-bottom:1rem; }
        .back-link { display:block; text-align:center; margin-top:1rem; color:#8a8a9a; font-size:0.82rem; text-decoration:none; }
        .back-link:hover { color:#c9a84c; }
    </style>
</head>
<body>
<div class="card">
    <div class="icon">🔐</div>
    <div class="title">Verificación en dos pasos</div>
    <div class="subtitle">Abre tu app autenticadora y escribe el código de 6 dígitos.</div>

    @if($errors->any())
    <div class="alert alert-danger py-2 mb-3" style="font-size:0.85rem;">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('2fa.verify.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="code" class="form-control"
                   maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                   autofocus placeholder="000000">
        </div>
        <button type="submit" class="btn btn-gold">Verificar</button>
    </form>
    <a href="{{ route('login') }}" class="back-link">← Volver al inicio de sesión</a>
</div>
</body>
</html>