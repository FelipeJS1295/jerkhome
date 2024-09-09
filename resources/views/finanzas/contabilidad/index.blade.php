@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Contabilidad</h1>
        <a href="{{ route('contabilidad.create') }}" class="btn btn-primary">Agregar Transacción</a>
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
                        <th>Cuenta</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transacciones as $transaccion)
                        <tr>
                            <td>{{ $transaccion->id }}</td>
                            <td>{{ $transaccion->cuenta->nombre }}</td>
                            <td>{{ $transaccion->tipo }}</td>
                            <td>{{ $transaccion->monto }}</td>
                            <td>{{ $transaccion->fecha }}</td>
                            <td>{{ $transaccion->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
