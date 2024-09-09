@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Agregar Documento</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('documentos.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="numero_documento" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Número de Documento</label>
                    <input type="text" class="form-control bg-secondary text-light" id="numero_documento" name="numero_documento" required>
                </div>
                <div class="form-group mb-3">
                    <label for="proveedor_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Proveedor</label>
                    <select class="form-control bg-secondary text-light" id="proveedor_id" name="proveedor_id" required>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_documento" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha Documento</label>
                    <input type="date" class="form-control bg-secondary text-light" id="fecha_documento" name="fecha_documento" required>
                </div>
                <div class="form-group mb-3">
                    <label for="vencimiento" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Vencimiento</label>
                    <input type="date" class="form-control bg-secondary text-light" id="vencimiento" name="vencimiento" required>
                </div>
                <div class="form-group mb-3">
                    <label for="monto_neto" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Monto Neto</label>
                    <input type="number" class="form-control bg-secondary text-light" id="monto_neto" name="monto_neto" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
