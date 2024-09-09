@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Registrar Pago</h1>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('documentos.registrarPago', $documento->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="tipo_pago">Tipo de Pago</label>
                    <input type="text" class="form-control" id="tipo_pago" name="tipo_pago" required>
                </div>
                <div class="form-group">
                    <label for="fecha_pago">Fecha de Pago</label>
                    <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                </div>
                <div class="form-group">
                    <label for="numero_pago">Número de Pago</label>
                    <input type="text" class="form-control" id="numero_pago" name="numero_pago" required>
                </div>
                <div class="form-group">
                    <label for="monto_pago">Monto de Pago</label>
                    <input type="number" class="form-control" id="monto_pago" name="monto_pago" required>
                </div>
                <div class="form-group">
                    <label for="cuotas">Cuotas</label>
                    <input type="number" class="form-control" id="cuotas" name="cuotas">
                </div>
                <button type="submit" class="btn btn-danger">Registrar Pago</button>
            </form>
        </div>
    </div>
</div>
@endsection
