<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — El Sepulturero Juan</title>
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

        .form-control::placeholder {
            color: #4a4a5a;
        }

        .form-check-input {
            background-color: #1a1a2e;
            border-color: rgba(201, 168, 76, 0.4);
        }

        .form-check-input:checked {
            background-color: #c9a84c;
            border-color: #c9a84c;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(201, 168, 76, 0.15);
        }

        .form-check-label {
            color: #8a8a9a;
            font-size: 0.85rem;
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

        .invalid-feedback {
            font-size: 0.78rem;
        }

        .badge-empleado {
            display: inline-block;
            background: rgba(201, 168, 76, 0.1);
            border: 1px solid rgba(201, 168, 76, 0.3);
            color: #c9a84c;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: 'Cinzel', serif;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="portal-card">
        <div class="text-center mb-3">
            <i class="bi bi-building" style="font-size:2rem; color:#c9a84c;"></i>
        </div>
        <div class="portal-logo">El Sepulturero Juan</div>
        <div class="portal-sub">Sistema Interno</div>
        <div class="text-center">
            <span class="badge-empleado">Acceso Empleados</span>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:0.85rem;">
            Usuario o contraseña incorrectos.
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="username"
                    class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username') }}" required autofocus
                    placeholder="nombre.usuario">
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required placeholder="••••••••">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>
            <button type="submit" class="btn-gold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
            </button>
        </form>

        <hr class="divider">
        <p class="text-center mb-0" style="font-size:0.8rem;">
            <a href="{{ route('cliente.login') }}" class="link-gold">
                <i class="bi bi-arrow-left me-1"></i>Portal de clientes
            </a>
        </p>
    </div>
</body>

</html>