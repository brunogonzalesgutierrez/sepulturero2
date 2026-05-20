<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
        @php
            $tipos = [
                'Limpieza general',
                'Limpieza profunda',
                'Reparación de estructura',
                'Pintura y restauración',
                'Mantenimiento de jardín',
                'Reposición de lápida',
                'Fumigación',
                'Drenaje y limpieza de agua',
                'Otro',
            ];
            $valorActual = old('nombre', $tipo_mantenimiento->nombre ?? '');
            $esPersonalizado = $valorActual && !in_array($valorActual, $tipos);
        @endphp
        <select name="nombre" id="nombre-select"
            class="form-select @error('nombre') is-invalid @enderror"
            onchange="toggleNombreCustom(this.value)" required>
            <option value="">Seleccione un tipo...</option>
            @foreach($tipos as $t)
            <option value="{{ $t }}" {{ $valorActual == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
            <option value="__otro__" {{ $esPersonalizado ? 'selected' : '' }}>Otro (escribir manualmente)</option>
        </select>
        <input type="text" id="nombre-custom"
            class="form-control mt-2 @error('nombre') is-invalid @enderror"
            placeholder="Escribe el nombre del tipo..."
            value="{{ $esPersonalizado ? $valorActual : '' }}"
            style="display: {{ $esPersonalizado ? 'block' : 'none' }};">
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

<script>
function toggleNombreCustom(val) {
    const custom = document.getElementById('nombre-custom');
    const select = document.getElementById('nombre-select');
    if (val === '__otro__') {
        custom.style.display = 'block';
        custom.required = true;
        custom.name = 'nombre';
        select.name = '_nombre_select';
    } else {
        custom.style.display = 'none';
        custom.required = false;
        custom.name = '_nombre_custom';
        select.name = 'nombre';
    }
}
toggleNombreCustom(document.getElementById('nombre-select').value);
</script>