@if(isset($visitas_pagina))
<div class="contador-visitas">
    <i class="bi bi-eye me-1"></i>
    Esta página ha sido visitada
    <strong>{{ number_format($visitas_pagina) }}</strong>
    {{ $visitas_pagina == 1 ? 'vez' : 'veces' }}
</div>
@endif