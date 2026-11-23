<?php

namespace App\Services;

use App\Models\Alerta;
use Illuminate\Support\Facades\Mail;

class NotificadorSMTP
{
    public function enviar(
        Alerta $alerta,
        string $destinatario
    ): void {
        $evento = $alerta->evento;

        $fechaLocal = $evento->fecha_hora
            ->copy()
            ->setTimezone('America/El_Salvador')
            ->format('d/m/Y H:i:s');

        $contenido =
            "ALERTA DE SEGURIDAD\n\n" .
            "Sistema de Vigilancia\n\n" .
            "Se ha detectado una apertura fuera del horario permitido.\n\n" .
            "Puerta: " . $evento->puerta->nombre . "\n" .
            "Evento: #" . $evento->id_evento . "\n" .
            "Alerta: #" . $alerta->id_alerta . "\n" .
            "Fecha y hora: " . $fechaLocal . "\n" .
            "Clasificacion: " . $evento->clasificacion . "\n\n" .
            "Alarma simulada: ACTIVADA";

        Mail::raw($contenido, function ($mensaje) use ($destinatario) {
            $mensaje->to($destinatario)
                ->subject('Alerta de seguridad - Apertura anomala');
        });
    }
}
