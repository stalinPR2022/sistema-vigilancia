<?php

namespace App\Services;

use App\Models\Alerta;
use App\Models\Notificacion;
use Carbon\CarbonImmutable;
use Throwable;

class GestorNotificaciones
{
    public function notificarPorSMTP(
        Alerta $alerta,
        NotificadorSMTP $notificador
    ): Notificacion {
        $destinatario = config(
            'vigilancia.smtp_destinatario'
        );

        // Registrar el intento antes de realizar el envio
        $notificacion = Notificacion::create([
            'id_alerta' => $alerta->id_alerta,
            'canal' => 'SMTP',
            'destinatario' => $destinatario,
            'estado' => 'PENDIENTE',
        ]);

        try {
            // Comunicarse con el servicio SMTP
            $notificador->enviar($alerta, $destinatario);

            // Registrar el resultado satisfactorio
            $notificacion->estado = 'ENVIADO';
            $notificacion->detalle_resultado =
                'Mensaje aceptado por el servidor SMTP.';

        } catch (Throwable $e) {

            // Registrar el error sin detener la simulacion
            $notificacion->estado = 'FALLIDO';
            $notificacion->detalle_resultado =
                'No fue posible enviar el mensaje por SMTP.';
        }

        // Registrar la fecha del intento en UTC
        $notificacion->fecha_hora_envio =
            CarbonImmutable::now('UTC')
                ->format('Y-m-d H:i:s');

        $notificacion->save();

        return $notificacion;
    }
}
