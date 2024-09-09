@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Evaluaciones de Trabajadores</h1>
        <a href="{{ route('evaluacion.create') }}" class="btn btn-primary">Agregar Evaluación</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Trabajador</th>
                        <th>Fecha</th>
                        <th>Desempeño</th>
                        <th>Asistencia</th>
                        <th>Habilidades Técnicas</th>
                        <th>Comunicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluaciones as $evaluacion)
                        <tr>
                            <td>{{ $evaluacion->id }}</td>
                            <td>{{ $evaluacion->trabajador->nombre }}</td>
                            <td>{{ $evaluacion->fecha }}</td>
                            <td>{{ $evaluacion->desempeño }}</td>
                            <td>{{ $evaluacion->asistencia }}</td>
                            <td>{{ $evaluacion->habilidades_tecnicas }}</td>
                            <td>{{ $evaluacion->comunicacion }}</td>
                            <td>
                                <a href="{{ route('evaluacion.edit', $evaluacion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('evaluacion.destroy', $evaluacion->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
