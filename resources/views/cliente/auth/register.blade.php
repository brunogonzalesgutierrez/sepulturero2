<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro — El Sepulturero Juan</title>
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
            padding: 2rem 1rem;
        }

        .portal-card {
            background: #16213e;
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 680px;
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
            margin-bottom: 1.5rem;
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

        .form-control::placeholder {
            color: #4a4a5a;
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

        .info-box {
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 6px;
            padding: 0.7rem 1rem;
            font-size: 0.82rem;
            color: #c9a84c;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="portal-card">
        <div class="text-center mb-3">
            <i class="bi bi-person-plus" style="font-size:2rem; color:#c9a84c;"></i>
        </div>
        <div class="portal-logo">El Sepulturero Juan</div>
        <div class="portal-sub">Crear cuenta de cliente</div>

        <div class="info-box">
            <i class="bi bi-info-circle me-2"></i>
            Necesita tener un CI registrado en nuestro sistema para crear su cuenta.
        </div>

        @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:0.85rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('cliente.register.post') }}">
            @csrf

            {{-- Fila 1: CI + Correo --}}
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label">CI <span class="text-danger">*</span></label>
                    <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror"
                        value="{{ old('ci') }}" required placeholder="7654321">
                    @error('ci')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                    <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                        value="{{ old('correo') }}" required placeholder="correo@ejemplo.com">
                    @error('correo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Fila 2: Contraseña + Confirmar --}}
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        required placeholder="Mín. 8 caracteres">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label class="form-label">Confirmar <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control"
                        required placeholder="Repita su contraseña">
                </div>
            </div>

            <button type="submit" class="btn-gold">
                <i class="bi bi-check-circle me-2"></i>Crear Cuenta
            </button>
        </form>

        <hr class="divider">
        <p class="text-center mb-0" style="font-size:0.85rem; color:#8a8a9a;">
            ¿Ya tiene cuenta?
            <a href="{{ route('cliente.login') }}" class="link-gold">Iniciar sesión</a>
        </p>
    </div>
</body>

</html>