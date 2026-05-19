<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
        <input type="text" name="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $tipo_mantenimiento->nombre ?? '') }}"
            placeholder="Ej: Limpieza, Reparación..."
            required>
        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Precio Base (BOB) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="precio_base"
            class="form-control @error('precio_base') is-invalid @enderror"
            value="{{ old('precio_base', $tipo_mantenimiento->precio_base ?? '') }}"
            placeholder="0.00"
            required>
        @error('precio_base')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-semibold">Descripción</label>
        <textarea name="descripcion" rows="3"
            class="form-control @error('descripcion') is-invalid @enderror"
            placeholder="Describe en qué consiste este tipo de mantenimiento...">{{ old('descripcion', $tipo_mantenimiento->descripcion ?? '') }}</textarea>
        @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>