@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Detalle del Tiempo Personal</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Trabajador:</label>
                <p>{{ $tiempoPersonal->trabajador->nombre }} {{ $tiempoPersonal->trabajador->apellido }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo:</label>
                <p>{{ ucfirst($tiempoPersonal->tipo) }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de Inicio:</label>
                <p>{{ $tiempoPersonal->fecha_inicio }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de Fin:</label>
                <p>{{ $tiempoPersonal->fecha_fin }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción:</label>
                <p>{{ $tiempoPersonal->descripcion }}</p>
            </div>
            <a href="{{ route('rrhh.tiempo_personal.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
