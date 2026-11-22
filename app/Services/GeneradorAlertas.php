<?php

namespace App\Services;

use App\Models\Alerta;
use App\Models\Evento;
use Carbon\CarbonImmutable;

class GeneradorAlertas
{
    public function generar(Evento $evento): ?Alerta
    {
        // Solo se generan alertas para eventos anomalos
        if ($evento->clasificacion !== 'ANOMALO') {
            return null;
        }

        // Evitar duplicar alertas del mismo evento
        return Alerta::firstOrCreate(
            ['id_evento' => $evento->id_evento],
            [
                'fecha_hora' => CarbonImmutable::now('UTC')
                    ->format('Y-m-d H:i:s'),

                'mensaje' => 'Apertura de puerta fuera del horario permitido.',

                'alarma_activada' => false,
            ]
        );
    }
}
