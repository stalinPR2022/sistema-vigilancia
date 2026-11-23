<?php

namespace App\Http\Controllers;

use App\Models\Puerta;
use App\Services\EvaluadorHorarios;
use App\Services\GestorEventos;
use App\Services\SensorPuertaSimulado;
use App\Services\GeneradorAlertas;
use App\Services\ControladorActuadorSimulado;
use App\Services\GestorNotificaciones;
use App\Services\NotificadorSMTP;

class SimulacionController extends Controller
{
    public function index()
    {
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->firstOrFail();

        return view('simulacion.index', compact('puerta'));
    }

        public function simular(
            SensorPuertaSimulado $sensor,
            GestorEventos $gestorEventos,
            EvaluadorHorarios $evaluador,
            GeneradorAlertas $generadorAlertas,
            ControladorActuadorSimulado $actuador,
            GestorNotificaciones $gestorNotificaciones,
            NotificadorSMTP $notificadorSMTP
        ){
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->where('activa', true)
            ->firstOrFail();

        // Generar apertura simulada
        $datos = $sensor->generarApertura($puerta);

        // Registrar, evaluar y generar alerta si corresponde
        $evento = $gestorEventos->registrar(
            $datos,
            $evaluador,
            $generadorAlertas,
            $actuador
        );

        // Obtener la alerta asociada, si existe
        $alerta = $evento->alerta;

        // Enviar notificacion solo si existe una alerta
        $notificacion = null;

        if ($alerta !== null) {
            $notificacion = $gestorNotificaciones->notificarPorSMTP(
                $alerta,
                $notificadorSMTP
            );
        }

        return redirect()
            ->route('simulacion.index')
            ->with('evento', [
                'id_evento' => $evento->id_evento,
                'id_puerta' => $evento->id_puerta,
                'tipo_evento' => $evento->tipo_evento,
                'fecha_hora' => $evento->fecha_hora
                    ->copy()
                    ->setTimezone('America/El_Salvador')
                    ->format('d/m/Y H:i:s'),
                'clasificacion' => $evento->clasificacion,
                'id_alerta' => $alerta?->id_alerta,
                'mensaje_alerta' => $alerta?->mensaje,
                'alarma_activada' => $alerta?->alarma_activada ?? false,
                'estado_notificacion' => $notificacion?->estado,
                'id_notificacion' => $notificacion?->id_notificacion,
                'canal_notificacion' => $notificacion?->canal,
            ]);
    }
}
