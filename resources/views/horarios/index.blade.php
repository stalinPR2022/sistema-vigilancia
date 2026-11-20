@extends('layouts.app')

@section('title', 'Configuración de horarios')

@section('content')

@php
    $dias = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    $diasSeleccionados = old(
        'dias',
        $horarios->pluck('dia_semana')->all()
    );

    // El formulario permite aplicar un mismo intervalo
    // a los días seleccionados.
    $primerHorario = $horarios->first();

    $horaInicio = old(
        'hora_inicio',
        $primerHorario
            ? substr($primerHorario->hora_inicio, 0, 5)
            : '08:00'
    );

    $horaFin = old(
        'hora_fin',
        $primerHorario
            ? substr($primerHorario->hora_fin, 0, 5)
            : '18:00'
    );
@endphp

<h2 class="mb-4">Configuración de horarios</h2>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Revise los datos ingresados:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header">
        <strong>{{ $puerta->nombre }}</strong>
    </div>

    <div class="card-body">

        <p class="text-muted">
            Seleccione los días y establezca el horario
            en el que se permiten las aperturas.
        </p>

        <form action="{{ route('horarios.guardar') }}"
              method="POST">

            @csrf

            <h5 class="mb-3">Días permitidos</h5>

            <div class="row mb-4">

                @foreach ($dias as $numero => $nombre)
                    <div class="col-md-4 col-sm-6 mb-2">

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="dias[]"
                                value="{{ $numero }}"
                                id="dia{{ $numero }}"
                                {{ in_array($numero, $diasSeleccionados) ? 'checked' : '' }}
                            >

                            <label class="form-check-label"
                                   for="dia{{ $numero }}">
                                {{ $nombre }}
                            </label>
                        </div>

                    </div>
                @endforeach

            </div>

            <h5 class="mb-3">Horario permitido</h5>

            <div class="row mb-4">

                <div class="col-md-6 mb-3">
                    <label for="hora_inicio"
                           class="form-label">
                        Hora de inicio
                    </label>

                    <input
                        type="time"
                        class="form-control"
                        id="hora_inicio"
                        name="hora_inicio"
                        value="{{ $horaInicio }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label for="hora_fin"
                           class="form-label">
                        Hora de finalización
                    </label>

                    <input
                        type="time"
                        class="form-control"
                        id="hora_fin"
                        name="hora_fin"
                        value="{{ $horaFin }}"
                        required
                    >
                </div>

            </div>

            <div class="alert alert-info">
                Se aplicará el mismo intervalo de horas
                a todos los días seleccionados.
                Los días desmarcados quedarán sin horario
                permitido.
            </div>

            <div class="text-end">
                <button type="submit"
                        class="btn btn-primary">
                    Guardar horarios
                </button>
            </div>

        </form>

    </div>
</div>

<div class="card shadow-sm">

    <div class="card-header">
        <strong>Horarios registrados</strong>
    </div>

    <div class="card-body">

        @if ($horarios->isEmpty())

            <p class="text-muted mb-0">
                No hay horarios configurados.
            </p>

        @else

            <div class="table-responsive">
                <table class="table table-striped table-bordered">

                    <thead class="table-dark">
                        <tr>
                            <th>Día</th>
                            <th>Hora de inicio</th>
                            <th>Hora de finalización</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($horarios as $horario)
                            <tr>
                                <td>
                                    {{ $dias[$horario->dia_semana] }}
                                </td>

                                <td>
                                    {{ substr($horario->hora_inicio, 0, 5) }}
                                </td>

                                <td>
                                    {{ substr($horario->hora_fin, 0, 5) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        @endif

    </div>
</div>

@endsection
