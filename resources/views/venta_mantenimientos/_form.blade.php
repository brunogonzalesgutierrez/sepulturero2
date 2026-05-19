<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-semibold">Mantenimiento <span class="text-danger">*</span></label>
        <select name="mantenimiento_id" id="mantenimiento_id"
            class="form-select @error('mantenimiento_id') is-invalid @enderror" required>
            <option value="">Seleccione un mantenimiento...</option>
            @foreach($mantenimientos as $m)
            <option value="{{ $m->id }}"
                data-precio="{{ $m->precio }}"
                {{ old('mantenimiento_id', $venta->mantenimiento_id ?? '') == $m->id ? 'selected' : '' }}>
                #{{ $m->id }} —
                {{ $m->tipoMantenimiento->nombre ?? '?' }} |
                {{ $m->espacio->cementerio->nombre }}
                Secc: {{ $m->espacio->direccion->seccion ?? '?' }}
                Nro: {{ $m->espacio->direccion->numero ?? '?' }} |
                {{ number_format($m->precio, 2) }} BOB
                [{{ ucfirst(str_replace('_',' ',$m->estado)) }}]
            </option>
            @endforeach
        </select>
        @error('mantenimiento_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
        <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
            <option value="">Seleccione un cliente...</option>
            @foreach($clientes as $c)
            <option value="{{ $c->id }}"
                {{ old('cliente_id', $venta->cliente_id ?? '') == $c->id ? 'selected' : '' }}>
                {{ $c->nombre }} {{ $c->paterno }} (CI: {{ $c->ci }})
            </option>
            @endforeach
        </select>
        @error('cliente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Empleado que Registra</label>
        <select name="empleado_id" class="form-select @error('empleado_id') is-invalid @enderror">
            <option value="">Seleccione...</option>
            @foreach($empleados as $e)
            <option value="{{ $e->id }}"
                {{ old('empleado_id', $venta->empleado_id ?? auth()->user()->empleado_id) == $e->id ? 'selected' : '' }}>
                {{ $e->nombre }} {{ $e->paterno }}
            </option>
            @endforeach
        </select>
        @error('empleado_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Precio (BOB) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="precio" id="precio-venta"
            class="form-control @error('precio') is-invalid @enderror"
            value="{{ old('precio', $venta->precio ?? '') }}" required>
        <small class="text-muted">Se carga automáticamente al elegir mantenimiento.</small>
        @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Estado Pago <span class="text-danger">*</span></label>
        <select name="estado_pago" class="form-select @error('estado_pago') is-invalid @enderror" required>
            <option value="pendiente" {{ old('estado_pago', $venta->estado_pago ?? 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="pagado"    {{ old('estado_pago', $venta->estado_pago ?? '') == 'pagado' ? 'selected' : '' }}>Pagado</option>
        </select>
        @error('estado_pago')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Método de Pago</label>
        <select name="metodo_pago" class="form-select @error('metodo_pago') is-invalid @enderror">
            <option value="">— Sin definir —</option>
            @foreach(['efectivo','transferencia','qr','online'] as $mp)
            <option value="{{ $mp }}"
                {{ old('metodo_pago', $venta->metodo_pago ?? '') == $mp ? 'selected' : '' }}>
                {{ ucfirst($mp) }}
            </option>
            @endforeach
        </select>
        @error('metodo_pago')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Fecha Solicitud <span class="text-danger">*</span></label>
        <input type="date" name="fecha_solicitud"
            class="form-control @error('fecha_solicitud') is-invalid @enderror"
            value="{{ old('fecha_solicitud', $venta->fecha_solicitud?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
            required>
        @error('fecha_solicitud')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-semibold">Observación</label>
        <textarea name="observacion" rows="3"
            class="form-control @error('observacion') is-invalid @enderror"
            placeholder="Notas adicionales...">{{ old('observacion', $venta->observacion ?? '') }}</textarea>
        @error('observacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<script>
document.getElementById('mantenimiento_id').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    const precio = opt.dataset.precio;
    if (precio) {
        document.getElementById('precio-venta').value = parseFloat(precio).toFixed(2);
    }
});
</script>