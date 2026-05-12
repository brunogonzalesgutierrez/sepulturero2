@extends('layouts.app')
@section('title', 'Configurar 2FA')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">🔐 Activar Autenticación de Dos Factores</div>
            <div class="card-body text-center">

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($user->two_factor_enabled)
                <div class="alert alert-success mb-3">
                    ✅ El 2FA está <strong>activado</strong> en tu cuenta.
                </div>

                <hr>
                <p class="text-muted">Para desactivarlo, ingresa tu código actual:</p>
                <form method="POST" action="{{ route('2fa.desactivar') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="code" class="form-control text-center"
                               maxlength="6" placeholder="000000" style="font-size:1.3rem; letter-spacing:0.4rem;">
                        @error('code')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-danger">Desactivar 2FA</button>
                </form>

                @else
                <p class="mb-3">Escanea este código QR con <strong>Google Authenticator</strong> o <strong>Authy</strong>:</p>

                <div class="mb-3 d-flex justify-content-center">
                    {!! $qrSvg !!}
                </div>

                <p class="text-muted small mb-3">
                    Luego ingresa el código de 6 dígitos que aparece en tu app para confirmar:
                </p>

                <form method="POST" action="{{ route('2fa.activate') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="code" class="form-control text-center"
                               maxlength="6" inputmode="numeric" placeholder="000000"
                               style="font-size:1.3rem; letter-spacing:0.4rem;">
                        @error('code')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success">Activar 2FA</button>
                </form>
                @endif

                <a href="{{ route('perfil.index') }}" class="btn btn-secondary mt-3">Volver al Perfil</a>
            </div>
        </div>
    </div>
</div>
@endsection