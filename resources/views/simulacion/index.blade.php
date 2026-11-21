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

            

            <div class="alert alert-info mb-0">
                 El evento fue registrado y evaluado correctamente.

                @if ($evento['clasificacion'] === 'ANOMALO')
                    La apertura ocurrió fuera del horario permitido.
                @else
                    La apertura ocurrió dentro del horario permitido.
                @endif
            </div>
        </div>
    </div>
@endif

@endsection
