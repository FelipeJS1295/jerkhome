@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Agregar Orden de Compra</h1>
    </div>

    <!-- Mostrar errores -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('ordenes-de-compra.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="fecha" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha</label>
                    <input type="date" class="form-control bg-secondary text-light" id="fecha" name="fecha" required>
                </div>
                <div class="form-group mb-3">
                    <label for="orden_de_compra" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Orden de Compra</label>
                    <input type="text" class="form-control bg-secondary text-light" id="orden_de_compra" name="orden_de_compra" required>
                </div>
                <div class="form-group mb-3">
                    <label for="cliente_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Cliente</label>
                    <select class="form-control bg-secondary text-light" id="cliente_id" name="cliente_id" required>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="producto_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Producto</label>
                    <select class="form-control bg-secondary text-light" id="producto_id" name="producto_id" required>
                        @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="monto" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Monto</label>
                    <input type="number" step="0.01" class="form-control bg-secondary text-light" id="monto" name="monto" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_envio" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha de Envío</label>
                    <input type="date" class="form-control bg-secondary text-light" id="fecha_envio" name="fecha_envio" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
