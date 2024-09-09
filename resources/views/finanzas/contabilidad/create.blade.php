@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Agregar Transacción</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('contabilidad.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="cuenta_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Cuenta</label>
                    <select id="cuenta_id" name="cuenta_id" class="form-control bg-secondary text-light" required>
                        @foreach($cuentas as $cuenta)
                            <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="tipo" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control bg-secondary text-light" required>
                        <option value="ingreso">Ingreso</option>
                        <option value="gasto">Gasto</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="monto" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Monto</label>
                    <input type="number" id="monto" name="monto" class="form-control bg-secondary text-light" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control bg-secondary text-light" required>
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
