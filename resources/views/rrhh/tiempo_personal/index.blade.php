@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Listado de Tiempos Personales</h1>
        <a href="{{ route('tiempo_personal.create') }}" class="btn btn-primary">Registrar Tiempo Personal</a>
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
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tiempos_personales as $tiempo)
                        <tr>
                            <td>{{ $tiempo->id }}</td>
                            <td>{{ $tiempo->trabajador->nombre }}</td>
                            <td>{{ $tiempo->fecha_inicio }}</td>
                            <td>{{ $tiempo->fecha_fin }}</td>
                            <td>{{ $tiempo->motivo }}</td>
                            <td>
                                <a href="{{ route('tiempo_personal.edit', $tiempo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('tiempo_personal.destroy', $tiempo->id) }}" method="POST" style="display:inline;">
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
