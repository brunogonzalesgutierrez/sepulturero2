<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CambioMonedaService
{
    /**
     * Convierte un monto de BOB a USD.
     * La tasa se cachea 1 hora para no llamar la API en cada pago.
     */
    public static function bobAUsd(float $monto): float
    {
        $tasa = Cache::remember('tasa_bob_usd', 3600, function () {
            try {
                $apiKey  = env('EXCHANGE_RATE_API_KEY');
                $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/pair/BOB/USD");

                if ($response->successful()) {
                    return $response->json('conversion_rate');
                }

                // Si falla la API usar tasa de respaldo
                return 0.1443; // 1 BOB ≈ 0.1443 USD (tasa aproximada)
            } catch (\Exception $e) {
                return 0.1443;
            }
        });

        return round($monto * $tasa, 2);
    }

    /**
     * Devuelve la tasa actual BOB → USD
     */
    public static function tasaActual(): float
    {
        return Cache::remember('tasa_bob_usd', 3600, function () {
            try {
                $apiKey   = env('EXCHANGE_RATE_API_KEY');
                $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/pair/BOB/USD");

                if ($response->successful()) {
                    return $response->json('conversion_rate');
                }

                return 0.1443;
            } catch (\Exception $e) {
                return 0.1443;
            }
        });
    }
}
