<?php

namespace App\Services;

use App\Models\Puerta;
use Carbon\CarbonImmutable;

class SensorPuertaSimulado
{
    public function generarApertura(Puerta $puerta): array
    {
        return [
            'id_puerta' => $puerta->id_puerta,
            'tipo_evento' => 'APERTURA',
            'fecha_hora' => CarbonImmutable::now(
                'America/El_Salvador'
            )->toIso8601String(),
        ];
    }
}
