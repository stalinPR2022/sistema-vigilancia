@extends('layouts.app')

@section('title', 'Detalle del evento')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detalle del evento #{{ $evento->id_evento }}</h2>

    <a href="{{ route('historial.index') }}"
       class="btn btn-secondary">
        Volver al historial
    </a>
</div>

<div class="card shadow-sm mb-4">

    <div class="card-header">
        <strong>Información del evento</strong>
    </div>

    <div class="card-body">

        <p>
            <strong>Puerta:</strong>
            {{ $evento->puerta->nombre }}
        </p>

        <p>
            <strong>Tipo:</strong>
            {{ $evento->tipo_evento }}
        </p>

        <p>
            <strong>Fecha y hora (El Salvador):</strong>
            {{ $evento->fecha_hora
                ->copy()
                ->setTimezone('America/El_Salvador')
                ->format('d/m/Y H:i:s') }}
        </p>

        <p>
            <strong>Clasificación:</strong>

            @if ($evento->clasificacion === 'AUTORIZADO')
                <span class="badge bg-success">AUTORIZADO</span>
            @elseif ($evento->clasificacion === 'ANOMALO')
                <span class="badge bg-danger">ANOMALO</span>
            @else
                <span class="badge bg-secondary">PENDIENTE</span>
            @endif
        </p>

    </div>
</div>

@if ($evento->alerta)

    <div class="card border-danger shadow-sm">

        <div class="card-header bg-danger text-white">
            <strong>Alerta de seguridad</strong>
        </div>

        <div class="card-body">

            <p>
                <strong>ID de alerta:</strong>
                {{ $evento->alerta->id_alerta }}
            </p>

            <p>
                <strong>Fecha y hora:</strong>
                {{ $evento->alerta->fecha_hora
                    ->copy()
                    ->setTimezone('America/El_Salvador')
                    ->format('d/m/Y H:i:s') }}
            </p>

            <p>
                <strong>Mensaje:</strong>
                {{ $evento->alerta->mensaje }}
            </p>

            <p class="mb-0">
                <strong>Alarma simulada:</strong>

                @if ($evento->alerta->alarma_activada)
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
    </div>

@else

    <div class="alert alert-info">
        Este evento no tiene una alerta asociada.
    </div>

@endif

@endsection
