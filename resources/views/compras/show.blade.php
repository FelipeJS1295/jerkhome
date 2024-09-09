@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalles de la Compra</h1>
    <p><strong>Fecha:</strong> {{ $compra->fecha }}</p>
    <p><strong>Fecha de Vencimiento:</strong> {{ $compra->fecha_vencimiento }}</p>
    <p><strong>Factura/Boleta:</strong> {{ $compra->factura_o_boleta }}</p>
    <p><strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}</p>
    <p><strong>Estado:</strong> {{ $compra->estado }}</p>
    <h3>Insumos</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compra->insumos as $insumo)
            <tr>
                <td>{{ $insumo->nombre }}</td>
                <td>{{ $insumo->pivot->precio_unitario }}</td>
                <td>{{ $insumo->pivot->cantidad }}</td>
                <td>{{ $insumo->pivot->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('compras.index') }}" class="btn btn-secondary">Volver a la Lista</a>
</div>
@endsection
