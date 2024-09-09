@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Órdenes de Compra</h1>
    <a href="{{ route('ordenes-de-compra.create') }}" class="btn btn-primary">Agregar Orden de Compra</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Orden de Compra</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Monto</th>
                <th>Fecha de Envío</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes as $orden)
            <tr>
                <td>{{ $orden->fecha }}</td>
                <td>{{ $orden->orden_de_compra }}</td>
                <td>{{ $orden->cliente->nombre }}</td>
                <td>{{ $orden->producto->nombre }}</td>
                <td>{{ $orden->monto }}</td>
                <td>{{ $orden->fecha_envio }}</td>
                <td>
                    <a href="{{ route('ordenes-de-compra.edit', $orden->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('ordenes-de-compra.destroy', $orden->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
