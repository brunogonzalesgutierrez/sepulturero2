<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class LibelulaService
{
    public static function registrarDeuda(array $datos): array
    {
        $response = Http::post(env('LIBELULA_URL') . '/rest/deuda/registrar', array_merge([
            'appkey' => env('LIBELULA_APPKEY'),
        ], $datos));

        return $response->json();
    }

    public static function consultarDeuda(string $identificador): array
    {
        $response = Http::post(env('LIBELULA_URL') . '/rest/deuda/consultar_deudas/por_identificador', [
            'appkey'       => env('LIBELULA_APPKEY'),
            'identificador' => $identificador,
        ]);

        return $response->json();
    }
}