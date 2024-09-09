@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Trabajadores</h1>
        <a href="{{ route('trabajadores.create') }}" class="btn btn-primary">Crear Nuevo Trabajador</a>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-light">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cargo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trabajadores as $trabajador)
                        <tr>
                            <td><a href="{{ route('trabajadores.show', $trabajador->id) }}">{{ $trabajador->rut }}</a></td>
                            <td>{{ $trabajador->nombre }}</td>
                            <td>{{ $trabajador->apellido }}</td>
                            <td>{{ $trabajador->cargo }}</td>
                            <td>
                                <a href="{{ route('trabajadores.edit', $trabajador->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('trabajadores.destroy', $trabajador->id) }}" method="POST" style="display:inline;">
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
</div>
@endsection
