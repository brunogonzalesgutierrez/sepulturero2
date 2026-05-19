<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:20px; }
        .container { max-width:600px; margin:0 auto; background:#fff; border-radius:8px; overflow:hidden; }
        .header { background:#1a1a2e; padding:25px 30px; text-align:center; }
        .header h1 { color:#c9a84c; font-size:20px; margin:0; }
        .header p { color:#8a8a9a; font-size:12px; margin:5px 0 0; }
        .body { padding:25px 30px; }
        .body p { color:#333; font-size:14px; line-height:1.6; }
        .highlight { background:#f9f6f0; border-left:4px solid #c9a84c; padding:12px 16px; border-radius:4px; margin:15px 0; }
        .footer { background:#f4f4f4; padding:15px 30px; text-align:center; }
        .footer p { color:#888; font-size:11px; margin:0; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🏛️ El Sepulturero Juan</h1>
        <p>Sistema de Gestión de Espacios Funerarios</p>
    </div>
    <div class="body">
        <p>Estimado/a,</p>
        <div class="highlight">
            <strong>Reporte adjunto:</strong> {{ $tipoReporte }}<br>
            <strong>Generado el:</strong> {{ now()->format('d/m/Y H:i') }}
        </div>
        @if($mensaje)
        <p>{{ $mensaje }}</p>
        @endif
        <p>Se adjunta el reporte en formato PDF. Si tiene alguna consulta, contáctenos.</p>
        <p>Atentamente,<br><strong>Sistema El Sepulturero Juan</strong></p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} Cementerio El Sepulturero Juan — sepulturerojuan.xyz</p>
    </div>
</div>
</body>
</html>