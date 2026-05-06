<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Cliente — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background: #1a1a2e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .portal-card {
            background: #16213e;
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .portal-logo {
            font-family: 'Cinzel', serif;
            color: #c9a84c;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-align: center;
            margin-bottom: 0.3rem;
        }

        .portal-sub {
            text-align: center;
            color: #8a8a9a;
            font-size: 0.8rem;
            margin-bottom: 2rem;
        }

        .form-label {
            color: #c9a84c;
            font-size: 0.8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-control {
            background: #1a1a2e;
            border: 1px solid rgba(201, 168, 76, 0.2);
            color: #e0d6c8;
            border-radius: 6px;
        }

        .form-control:focus {
            background: #1a1a2e;
            border-color: #c9a84c;
            color: #e0d6c8;
            box-shadow: 0 0 0 0.2rem rgba(201, 168, 76, 0.15);
        }

        .btn-gold {
            background: #c9a84c;
            border: none;
            color: #1a1a2e;
            font-weight: 700;
            font-family: 'Cinzel', serif;
            letter-spacing: 1px;
            padding: 0.7rem;
            border-radius: 6px;
            width: 100%;
            transition: all 0.2s;
        }

        .btn-gold:hover {
            background: #e8c96a;
            color: #1a1a2e;
        }

        .link-gold {
            color: #c9a84c;
            text-decoration: none;
        }

        .link-gold:hover {
            color: #e8c96a;
        }

        .divider {
            border-color: rgba(201, 168, 76, 0.15);
            margin: 1.5rem 0;
        }
    </style>
</head>

<body>
    <div class="portal-card">
        <div class="text-center mb-3">
            <i class="bi bi-building" style="font-size:2rem; color:#c9a84c;"></i>
        </div>
        <div class="portal-logo">El Sepulturero Juan</div>
        <div class="portal-sub">Portal de Clientes</div>

        @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:0.85rem;">
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success py-2 mb-3" style="font-size:0.85rem;">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('cliente.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" class="form-control"
                    value="{{ old('correo') }}" required autofocus
                    placeholder="correo@ejemplo.com">
            </div>
            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control"
                    required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-gold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
            </button>
        </form>

        <hr class="divider">
        <p class="text-center mb-0" style="font-size:0.85rem; color:#8a8a9a;">
            ¿No tiene cuenta?
            <a href="{{ route('cliente.register') }}" class="link-gold">Regístrese aquí</a>
        </p>
        <p class="text-center mt-2 mb-0" style="font-size:0.8rem;">
            <a href="{{ route('login') }}" class="link-gold">
                <i class="bi bi-arrow-left me-1"></i>Acceso empleados
            </a>
        </p>
    </div>
</body>

</html>