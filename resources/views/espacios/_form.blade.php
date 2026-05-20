<div class="row g-3">
    {{-- Cementerio --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Cementerio <span class="text-danger">*</span></label>
        <select name="cementerio_id" class="form-select @error('cementerio_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($cementerios as $c)
            <option value="{{ $c->id }}" {{ old('cementerio_id', $espacio->cementerio_id ?? '') == $c->id ? 'selected':'' }}>
                {{ $c->nombre }}
            </option>
            @endforeach
        </select>
        @error('cementerio_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Tipo --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Tipo de Espacio <span class="text-danger">*</span></label>
        <select name="tipo_inhumacion_id" id="tipo_select"
            class="form-select @error('tipo_inhumacion_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($tipos as $t)
            <option value="{{ $t->id }}"
                data-precio-m2="{{ $t->precio_m2 }}"
                data-precio="{{ $t->precio }}"
                {{ old('tipo_inhumacion_id', $espacio->tipo_inhumacion_id ?? '') == $t->id ? 'selected':'' }}>
                {{ $t->nombre }} — {{ number_format($t->precio_m2, 2) }} BOB/m²
            </option>
            @endforeach
        </select>
        @error('tipo_inhumacion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Info del tipo seleccionado --}}
    <div class="col-12" id="info-tipo-box" style="display:none;">
        <div class="alert alert-info py-2 mb-0">
            <div class="row g-2 text-center">
                <div class="col">
                    <small class="text-muted d-block">Precio por m²</small>
                    <strong id="info-precio-m2-tipo">—</strong>
                </div>
                <div class="col">
                    <small class="text-muted d-block">Precio fijo inhumación</small>
                    <strong id="info-precio-fijo-tipo">—</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Dimensiones --}}
    <div class="col-12">
        <hr class="my-1"><small class="text-muted fw-semibold">DIMENSIONES</small>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Ancho (m) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="ancho"
            class="form-control @error('ancho') is-invalid @enderror"
            value="{{ old('ancho', $espacio->dimension->ancho ?? '') }}" required>
        @error('ancho')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Largo (m) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="largo"
            class="form-control @error('largo') is-invalid @enderror"
            value="{{ old('largo', $espacio->dimension->largo ?? '') }}" required>
        @error('largo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    {{-- precio_m2 ELIMINADO — ahora viene del tipo --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            @foreach(['disponible','ocupado','mantenimiento','reservado'] as $est)
            <option value="{{ $est }}" {{ old('estado', $espacio->estado ?? 'disponible') == $est ? 'selected':'' }}>
                {{ ucfirst($est) }}
            </option>
            @endforeach
        </select>
        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Dirección --}}
    <div class="col-12">
        <hr class="my-1"><small class="text-muted fw-semibold">UBICACIÓN DENTRO DEL CEMENTERIO</small>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold">Sección <span class="text-danger">*</span></label>
        <input type="text" name="seccion" class="form-control @error('seccion') is-invalid @enderror"
            value="{{ old('seccion', $espacio->direccion->seccion ?? '') }}" required>
        @error('seccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold">Fila <span class="text-danger">*</span></label>
        <input type="text" name="fila" class="form-control @error('fila') is-invalid @enderror"
            value="{{ old('fila', $espacio->direccion->fila ?? '') }}" required>
        @error('fila')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold">Número <span class="text-danger">*</span></label>
        <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror"
            value="{{ old('numero', $espacio->direccion->numero ?? '') }}" required>
        @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold">Calle/Pasillo <span class="text-danger">*</span></label>
        <input type="text" name="calle" class="form-control @error('calle') is-invalid @enderror"
            value="{{ old('calle', $espacio->direccion->calle ?? '') }}" required>
        @error('calle')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

@push('scripts')
<script>
    const tipoSelect = document.getElementById('tipo_select');
    const infoTipoBox = document.getElementById('info-tipo-box');

    function actualizarInfoTipo() {
        const opt = tipoSelect.options[tipoSelect.selectedIndex];
        if (!opt || !opt.value) {
            infoTipoBox.style.display = 'none';
            return;
        }
        document.getElementById('info-precio-m2-tipo').textContent =
            parseFloat(opt.dataset.precioM2 || 0).toFixed(2) + ' BOB/m²';
        document.getElementById('info-precio-fijo-tipo').textContent =
            parseFloat(opt.dataset.precio || 0).toFixed(2) + ' BOB';
        infoTipoBox.style.display = 'block';
    }

    tipoSelect.addEventListener('change', actualizarInfoTipo);
    actualizarInfoTipo();
</script>
@endpush