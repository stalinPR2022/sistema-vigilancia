@extends('layouts.app')

@section('title', 'Historial de eventos')

@section('content')

<h2 class="mb-4">Historial de eventos</h2>

<div class="card shadow-sm">
    <div class="card-header">
        <strong>Eventos registrados</strong>
    </div>

    <div class="card-body">

        @if ($eventos->isEmpty())

            <div class="alert alert-info mb-0">
                No hay eventos registrados.
            </div>

        @else

            <div class="table-responsive">

                <table class="table table-striped table-bordered align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha y hora</th>
                            <th>Puerta</th>
                            <th>Clasificación</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($eventos as $evento)
                            <tr>
                                <td>{{ $evento->id_evento }}</td>

                                <td>
                                    {{ $evento->fecha_hora
                                        ->copy()
                                        ->setTimezone('America/El_Salvador')
                                        ->format('d/m/Y H:i:s') }}
                                </td>

                                <td>
                                    {{ $evento->puerta->nombre }}
                                </td>

                                <td>
                                    @if ($evento->clasificacion === 'AUTORIZADO')
                                        <span class="badge bg-success">
                                            AUTORIZADO
                                        </span>
                                    @elseif ($evento->clasificacion === 'ANOMALO')
                                        <span class="badge bg-danger">
                                            ANOMALO
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            PENDIENTE
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('historial.show', $evento->id_evento) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $eventos->links() }}
            </div>

        @endif

    </div>
</div>

@endsection
