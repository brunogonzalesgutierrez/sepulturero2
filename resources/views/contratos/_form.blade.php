<div class="row g-3">

    {{-- CLIENTE --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
        <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($clientes as $c)
            <option value="{{ $c->id }}"
                {{ old('cliente_id', $contrato?->cliente_id) == $c->id ? 'selected' : '' }}>
                {{ $c->nombre }} {{ $c->paterno }} (CI: {{ $c->ci }})
            </option>
            @endforeach
        </select>
        @error('cliente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- ESPACIO --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Espacio <span class="text-danger">*</span></label>
        <select name="espacio_id" id="espacio_select"
            class="form-select @error('espacio_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach($espacios as $e)
            @php
                $ancho           = $e->dimension->ancho ?? 0;
                $largo           = $e->dimension->largo ?? 0;
                $precioM2        = $e->precio_m2 ?? 0;
                $precioCalculado = round($ancho * $largo * $precioM2, 2);
            @endphp
            <option value="{{ $e->id }}"
                data-precio="{{ $precioCalculado }}"
                data-ancho="{{ $ancho }}"
                data-largo="{{ $largo }}"
                data-precio-m2="{{ $precioM2 }}"
                data-tipo="{{ $e->tipoInhumacion->nombre ?? '' }}"
                {{ old('espacio_id', $contrato?->espacio_id) == $e->id ? 'selected' : '' }}>
                Espacio #{{ $e->id }} — {{ $e->cementerio->nombre ?? '' }}
                | {{ $e->tipoInhumacion->nombre ?? '' }}
                | Secc: {{ $e->direccion->seccion ?? '?' }}
                Nro: {{ $e->direccion->numero ?? '?' }}
                | {{ $ancho }}m × {{ $largo }}m
                | {{ number_format($precioCalculado, 2) }} BOB
            </option>
            @endforeach
        </select>
        @error('espacio_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- INFO DEL ESPACIO SELECCIONADO --}}
    <div class="col-md-12" id="info-espacio" style="display:none;">
        <div class="alert alert-info py-2 mb-0">
            <div class="row g-2 text-center">
                <div class="col">
                    <small class="text-muted d-block">Tipo</small>
                    <strong id="info-tipo">—</strong>
                </div>
                <div class="col">
                    <small class="text-muted d-block">Dimensiones</small>
                    <strong id="info-dims">—</strong>
                </div>
                <div class="col">
                    <small class="text-muted d-block">Precio/m²</small>
                    <strong id="info-precio-m2">—</strong>
                </div>
                <div class="col">
                    <small class="text-muted d-block">Precio calculado</small>
                    <strong id="info-precio-total" class="text-success">—</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- FECHA CONTRATO --}}
    <div class="col-md-3">
        <label class="form-label fw-semibold">Fecha Contrato <span class="text-danger">*</span></label>
        <input type="date" name="fecha_contrato"
            class="form-control @error('fecha_contrato') is-invalid @enderror"
            value="{{ old('fecha_contrato', $contrato?->fecha_contrato?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
            required>
        @error('fecha_contrato')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- MONTO BASE --}}
    <div class="col-md-3">
        <label class="form-label fw-semibold">Monto Base <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="monto_base" id="monto_base"
            class="form-control @error('monto_base') is-invalid @enderror"
            value="{{ old('monto_base', $contrato?->monto_base ?? '') }}"
            placeholder="Se calcula al elegir espacio"
            required>
        <small class="text-muted">Se autocompleta al seleccionar el espacio. Puedes ajustarlo.</small>
        @error('monto_base')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- MONEDA --}}
    <div class="col-md-3">
        <label class="form-label fw-semibold">Moneda <span class="text-danger">*</span></label>
        <select name="moneda" class="form-select @error('moneda') is-invalid @enderror" required>
            <option value="BOB" {{ old('moneda', $contrato?->moneda ?? 'BOB') == 'BOB' ? 'selected' : '' }}>BOB</option>
            <option value="USD" {{ old('moneda', $contrato?->moneda ?? '') == 'USD' ? 'selected' : '' }}>USD</option>
        </select>
        @error('moneda')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- ESTADO --}}
    <div class="col-md-3">
        <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            <option value="activo"     {{ old('estado', $contrato?->estado ?? 'activo') == 'activo'     ? 'selected' : '' }}>Activo</option>
            <option value="finalizado" {{ old('estado', $contrato?->estado ?? '') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
            <option value="cancelado"  {{ old('estado', $contrato?->estado ?? '') == 'cancelado'  ? 'selected' : '' }}>Cancelado</option>
        </select>
        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

</div>

@push('scripts')
<script>
    const espacioSelect = document.getElementById('espacio_select');
    const montoBase     = document.getElementById('monto_base');
    const infoBox       = document.getElementById('info-espacio');

    function actualizarInfoEspacio() {
        const opt = espacioSelect.options[espacioSelect.selectedIndex];

        if (!opt || !opt.value) {
            infoBox.style.display = 'none';
            return;
        }

        const precio   = parseFloat(opt.dataset.precio   || 0);
        const ancho    = parseFloat(opt.dataset.ancho     || 0);
        const largo    = parseFloat(opt.dataset.largo     || 0);
        const precioM2 = parseFloat(opt.dataset.precioM2  || 0);
        const tipo     = opt.dataset.tipo || '—';

        // Autocompletar monto base solo si está vacío
        if (!montoBase.value || montoBase.value == '0') {
            montoBase.value = precio.toFixed(2);
        }

        // Mostrar info
        document.getElementById('info-tipo').textContent        = tipo;
        document.getElementById('info-dims').textContent        = ancho + 'm × ' + largo + 'm = ' + (ancho * largo).toFixed(2) + 'm²';
        document.getElementById('info-precio-m2').textContent   = precioM2.toFixed(2) + ' BOB/m²';
        document.getElementById('info-precio-total').textContent = precio.toFixed(2) + ' BOB';

        infoBox.style.display = 'block';
    }

    espacioSelect.addEventListener('change', function () {
        montoBase.value = ''; // limpiar para que autocomplete con el nuevo espacio
        actualizarInfoEspacio();
    });

    // Al cargar la página (modo edición o cuando hay old())
    actualizarInfoEspacio();
</script>
@endpush