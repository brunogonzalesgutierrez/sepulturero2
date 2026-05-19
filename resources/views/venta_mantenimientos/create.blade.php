@extends('layouts.app')
@section('title', 'Nueva Venta de Mantenimiento')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-cart-plus me-2"></i>Nueva Venta de Mantenimiento</h1>
    <a href="{{ route('venta_mantenimientos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>
<div class="card">
    <div class="card-header py-2">Datos de la venta</div>
    <div class="card-body">
        <form method="POST" action="{{ route('venta_mantenimientos.store') }}">
            @csrf
            @include('venta_mantenimientos._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-gold">
                    <i class="bi bi-save me-1"></i>Registrar Venta
                </button>
                <a href="{{ route('venta_mantenimientos.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection