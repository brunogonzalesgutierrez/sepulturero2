@extends('layouts.app')
@section('title', 'Nuevo Tipo de Mantenimiento')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-plus-circle me-2"></i>Nuevo Tipo de Mantenimiento</h1>
    <a href="{{ route('tipo_mantenimientos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-header py-2">Datos del tipo de mantenimiento</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tipo_mantenimientos.store') }}">
            @csrf
            @include('tipo_mantenimientos._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-gold">
                    <i class="bi bi-save me-1"></i>Guardar
                </button>
                <a href="{{ route('tipo_mantenimientos.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection