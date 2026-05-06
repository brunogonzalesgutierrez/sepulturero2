<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil — El Sepulturero Juan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #c9a84c;
            --accent-hover: #e8c96a;
            --text: #e0d6c8;
            --muted: #8a8a9a;
        }

        body {
            font-family: 'Lato', sans-serif;
            background: var(--primary);
            color: var(--text);
            min-height: 100vh;
        }

        .top-bar {
            background: var(--secondary);
            border-bottom: 2px solid var(--accent);
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        /*   NAV LINKs*/

        .nav-links {
            display: flex;
            gap: 0.25rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--cream-dim);
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--gold);
            background: rgba(201, 168, 76, 0.08);
        }

        /* */


        .brand {
            font-family: 'Cinzel', serif;
            color: var(--accent);
            font-size: 1rem;
            font-weight: 700;
        }

        .user-info {
            color: var(--muted);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-logout {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            font-size: 0.8rem;
            padding: 4px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: var(--accent);
            color: var(--primary);
        }

        .main {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .page-title {
            font-family: 'Cinzel', serif;
            color: var(--accent);
            font-size: 1.3rem;
            border-bottom: 1px solid rgba(201, 168, 76, 0.3);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-card {
            background: var(--secondary);
            border: 1px solid rgba(201, 168, 76, 0.15);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .section-header {
            background: var(--primary);
            color: var(--accent);
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            padding: 0.75rem 1.2rem;
            border-radius: 8px 8px 0 0;
            border-bottom: 1px solid rgba(201, 168, 76, 0.15);
        }

        .form-label {
            color: var(--accent);
            font-size: 0.78rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-control {
            background: #1a1a2e;
            border: 1px solid rgba(201, 168, 76, 0.2);
            color: var(--text);
            border-radius: 6px;
        }

        .form-control:focus {
            background: #1a1a2e;
            border-color: var(--accent);
            color: var(--text);
            box-shadow: 0 0 0 0.2rem rgba(201, 168, 76, 0.15);
        }

        .form-control:disabled {
            background: #0f0f1a;
            color: var(--muted);
        }

        .btn-gold {
            background: var(--accent);
            border: none;
            color: var(--primary);
            font-weight: 700;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-gold:hover {
            background: var(--accent-hover);
            color: var(--primary);
        }

        .btn-back {
            background: transparent;
            border: 1px solid rgba(201, 168, 76, 0.3);
            color: var(--muted);
            font-size: 0.82rem;
            padding: 0.4rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .alert-success-custom {
            background: rgba(25, 135, 84, 0.15);
            border: 1px solid rgba(25, 135, 84, 0.4);
            border-radius: 6px;
            padding: 0.75rem 1rem;
            color: #75d6a1;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }



        /* Fix filas blancas Bootstrap 5 */
        .table> :not(caption)>*>* {
            background-color: transparent;
            color: var(--text);
            border-bottom-color: rgba(201, 168, 76, 0.1);
        }

        .table tbody tr:hover>* {
            background-color: transparent !important;
        }
    </style>
</head>

<body>

    <div class="top-bar">
        <div class="brand"><i class="bi bi-building me-2"></i>El Sepulturero Juan</div>


        <div class="nav-links">
            <a href="{{ route('home') }}#inicio">Inicio</a>
            <a href="{{ route('cliente.dashboard') }}">Dashboard</a>

            <!--falta contrato-->


            <a href="{{ route('cliente.cuotas') }}">Cuotas</a>


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
        <div class="page-title">
            <span><i class="bi bi-person-circle me-2"></i>Mi Perfil</span>
            <a href="{{ route('cliente.dashboard') }}" class="btn-back">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>

        @if(session('success'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        </div>
        @endif

        <div class="row g-3">
            {{-- Datos personales (solo lectura) --}}
            <div class="col-md-5">
                <div class="section-card">
                    <div class="section-header"><i class="bi bi-person me-1"></i>Datos Personales</div>
                    <div class="p-3">
                        <table class="table table-sm table-borderless mb-0" style="color:var(--text);">
                            <tr>
                                <th style="color:var(--muted); font-weight:400; width:40%;">CI</th>
                                <td>{{ $cliente->ci }}</td>
                            </tr>
                            <tr>
                                <th style="color:var(--muted); font-weight:400;">Nombre</th>
                                <td>{{ $cliente->nombre }} {{ $cliente->paterno }} {{ $cliente->materno }}</td>
                            </tr>
                            <tr>
                                <th style="color:var(--muted); font-weight:400;">Usuario</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th style="color:var(--muted); font-weight:400;">Estado</th>
                                <td>
                                    <span class="badge" style="background:#198754;">{{ ucfirst($cliente->estado) }}</span>
                                </td>
                            </tr>
                        </table>
                        <small style="color:var(--muted); font-size:0.75rem;">
                            <i class="bi bi-lock me-1"></i>Estos datos solo pueden ser modificados por el administrador.
                        </small>
                    </div>
                </div>
            </div>

            {{-- Datos editables --}}
            <div class="col-md-7">
                <div class="section-card mb-3">
                    <div class="section-header"><i class="bi bi-pencil me-1"></i>Actualizar Contacto</div>
                    <div class="p-3">
                        <form method="POST" action="{{ route('cliente.perfil.update') }}">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control"
                                    value="{{ old('correo', $cliente->correo) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control"
                                    value="{{ old('telefono', $cliente->telefono) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control"
                                    value="{{ old('direccion', $cliente->direccion) }}">
                            </div>
                            <button type="submit" class="btn btn-gold">
                                <i class="bi bi-save me-1"></i>Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Cambiar contraseña --}}
                <div class="section-card">
                    <div class="section-header"><i class="bi bi-lock me-1"></i>Cambiar Contraseña</div>
                    <div class="p-3">
                        <form method="POST" action="{{ route('cliente.perfil.update') }}">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password"
                                    placeholder="Mínimo 8 caracteres">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control" autocomplete="new-password">
                            </div>
                            <button type="submit" class="btn btn-gold">
                                <i class="bi bi-key me-1"></i>Cambiar Contraseña
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>