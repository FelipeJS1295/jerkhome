@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Agregar Tiempo Personal</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('tiempo_personal.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="trabajador_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Trabajador</label>
                    <select id="trabajador_id" name="trabajador_id" class="form-control bg-secondary text-light" required>
                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="tipo" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control bg-secondary text-light" required>
                        <option value="vacaciones">Vacaciones</option>
                        <option value="licencia">Licencia</option>
                        <option value="permiso">Permiso</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_inicio" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control bg-secondary text-light" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_fin" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha de Fin</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control bg-secondary text-light" required>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-control bg-secondary text-light"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection