@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Crear Nuevo Cliente</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="rut" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">RUT</label>
                    <input type="text" class="form-control bg-secondary text-light" id="rut" name="rut" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Nombre</label>
                    <input type="text" class="form-control bg-secondary text-light" id="nombre" name="nombre" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection

