<?php

namespace App\Services;

use App\Models\Alerta;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class NotificadorTelegram
{
    public function enviar(
        Alerta $alerta,
        string $chatId
    ): void {
        $token = config('vigilancia.telegram_token');

        if (blank($token) || blank($chatId)) {
            throw new RuntimeException(
                'Configuracion de Telegram incompleta.'
            );
        }

        $evento = $alerta->evento;

        $fechaLocal = $evento->fecha_hora
            ->copy()
            ->setTimezone('America/El_Salvador')
            ->format('d/m/Y H:i:s');

        $contenido =
            "ALERTA DE SEGURIDAD\n\n" .
            "Sistema de Vigilancia\n\n" .
            "Apertura fuera del horario permitido.\n\n" .
            "Puerta: " . $evento->puerta->nombre . "\n" .
            "Evento: #" . $evento->id_evento . "\n" .
            "Alerta: #" . $alerta->id_alerta . "\n" .
            "Fecha y hora: " . $fechaLocal . "\n" .
            "Clasificacion: " . $evento->clasificacion . "\n" .
            "Alarma simulada: ACTIVADA";

        $respuesta = Http::connectTimeout(3)
            ->timeout(config('vigilancia.telegram_timeout', 5))
            ->post(
                'https://api.telegram.org/bot'
                . $token
                . '/sendMessage',
                [
                    'chat_id' => $chatId,
                    'text' => $contenido,
                ]
            );

        // Detectar errores HTTP y errores de la API.
        $respuesta->throw();

        if ($respuesta->json('ok') !== true) {
            throw new RuntimeException(
                'Telegram no acepto el mensaje.'
            );
        }
    }
}
