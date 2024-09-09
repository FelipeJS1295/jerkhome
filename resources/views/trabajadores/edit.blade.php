@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Editar Trabajador</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('trabajadores.update', $trabajador->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Nombre</label>
                    <input type="text" class="form-control bg-secondary text-light" id="nombre" name="nombre" value="{{ $trabajador->nombre }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="apellido" class="form-label" style="background-color: #343a40; padding: 5px 10px; border: 5px;">Apellido</label>
                    <input type="text" class="form-control bg-secondary text-light" id="apellido" name="apellido" value="{{ $trabajador->apellido }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="rut" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">RUT</label>
                    <input type="text" class="form-control bg-secondary text-light" id="rut" name="rut" value="{{ $trabajador->rut }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_nacimiento" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha de Nacimiento</label>
                    <input type="date" class="form-control bg-secondary text-light" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $trabajador->fecha_nacimiento }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="direccion" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Dirección</label>
                    <input type="text" class="form-control bg-secondary text-light" id="direccion" name="direccion" value="{{ $trabajador->direccion }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="telefono" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Teléfono</label>
                    <input type="text" class="form-control bg-secondary text-light" id="telefono" name="telefono" value="{{ $trabajador->telefono }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Correo Electrónico</label>
                    <input type="email" class="form-control bg-secondary text-light" id="email" name="email" value="{{ $trabajador->email }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="afp" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">AFP</label>
                    <input type="text" class="form-control bg-secondary text-light" id="afp" name="afp" value="{{ $trabajador->afp }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="isapre_fonasa" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Isapre o Fonasa</label>
                    <input type="text" class="form-control bg-secondary text-light" id="isapre_fonasa" name="isapre_fonasa" value="{{ $trabajador->isapre_fonasa }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="cargo" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Cargo</label>
                    <input type="text" class="form-control bg-secondary text-light" id="cargo" name="cargo" value="{{ $trabajador->cargo }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="sueldo" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Sueldo</label>
                    <input type="number" step="0.01" class="form-control bg-secondary text-light" id="sueldo" name="sueldo" value="{{ $trabajador->sueldo }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_ingreso" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha de Ingreso</label>
                    <input type="date" class="form-control bg-secondary text-light" id="fecha_ingreso" name="fecha_ingreso" value="{{ $trabajador->fecha_ingreso }}" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Actualizar</button>
            </form>
        </div>
    </div>
</div>
@endsection