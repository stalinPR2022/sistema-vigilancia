@extends('layouts.app')

@section('title', 'Simulación de apertura')

@section('content')

<h2 class="mb-4">Simulación de apertura</h2>

<div class="card shadow-sm mb-4">
    <div class="card-header">
        <strong>{{ $puerta->nombre }}</strong>
    </div>

    <div class="card-body">
        <p>
            Desde esta sección puede simular una apertura
            de la puerta principal.
        </p>

        <p>
            <strong>Estado de la puerta:</strong>
            <span class="badge bg-secondary">
                Cerrada
            </span>
        </p>

        <form action="{{ route('simulacion.ejecutar') }}"
              method="POST">
            @csrf

            <button type="submit" class="btn btn-primary">
                Simular apertura
            </button>
        </form>
    </div>
</div>

@if (session('evento'))
    @php
        $evento = session('evento');
    @endphp

    <div class="alert alert-success">
        Apertura simulada correctamente.
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Resultado de la simulación</strong>
        </div>

        <div class="card-body">
            <p>
                <strong>ID de puerta:</strong>
                {{ $evento['id_puerta'] }}
            </p>
            <!-- datos del evento: ID -->
            <p>
                <strong>ID del evento:</strong>
                {{ $evento['id_evento'] }}
            </p>

            <p>
                <strong>Tipo de evento:</strong>
                {{ $evento['tipo_evento'] }}
            </p>

            <!-- datos del evento: clasificacion -->
            <p>
                <strong>Clasificación:</strong>

                @if ($evento['clasificacion'] === 'AUTORIZADO')
                    <span class="badge bg-success">
                        AUTORIZADO
                    </span>
                @elseif ($evento['clasificacion'] === 'ANOMALO')
                    <span class="badge bg-danger">
                        ANOMALO
                    </span>
                @else
                    <span class="badge bg-secondary">
                        PENDIENTE
                    </span>
                @endif
            </p>

            <p>
                <strong>Fecha y hora:</strong>
                {{ $evento['fecha_hora'] }}
            </p>
            
                
            @if ($evento['clasificacion'] === 'ANOMALO')

                <div class="alert alert-danger mt-3">

                    <h5 class="alert-heading">
                        ¡Alerta de seguridad!
                    </h5>

                    <p>
                        {{ $evento['mensaje_alerta'] }}
                    </p>

                    <p>
                        <strong>ID de alerta:</strong>
                        {{ $evento['id_alerta'] }}
                    </p>

                    <p class="mb-0">
                        <strong>Alarma simulada:</strong>

                        @if ($evento['alarma_activada'])
                            <span class="badge bg-danger">
                                ACTIVADA
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                NO ACTIVADA
                            </span>
                        @endif
                    </p>

                </div>

            @else

                <div class="alert alert-success mt-3">
                    Apertura autorizada.
                    No se generó ninguna alerta de seguridad.
                </div>
            @endif

            
            @if (!empty($evento['estado_notificacion']))

                <div class="card mt-3">

                    <div class="card-header">
                        <strong>Notificación por correo electrónico</strong>
                    </div>

                    <div class="card-body">

                        <p>
                            <strong>Canal:</strong>
                            {{ $evento['canal_notificacion'] }}
                        </p>

                        <p>
                            <strong>ID de notificación:</strong>
                            {{ $evento['id_notificacion'] }}
                        </p>

                        <p class="mb-0">
                            <strong>Estado:</strong>

                            @if ($evento['estado_notificacion'] === 'ENVIADO')
                                <span class="badge bg-success">
                                    ENVIADO
                                </span>
                            @elseif ($evento['estado_notificacion'] === 'FALLIDO')
                                <span class="badge bg-danger">
                                    FALLIDO
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    PENDIENTE
                                </span>
                            @endif
                        </p>

                    </div>
                </div>

            @endif


            
        </div>
    </div>
@endif

@endsection
