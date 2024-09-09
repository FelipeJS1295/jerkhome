@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Compras</h1>

    <!-- Botón para agregar una nueva compra -->
    <a href="{{ route('compras.create') }}" class="btn btn-primary mb-3">Agregar Compra</a>

    <!-- Tabla de compras -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Fecha de Vencimiento</th>
                <th>Factura/Boleta</th>
                <th>Proveedor</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td>{{ $compra->id }}</td>
                    <td>{{ $compra->fecha->format('d/m/Y') }}</td>
                    <td>{{ $compra->fecha_vencimiento->format('d/m/Y') }}</td>
                    <td>{{ $compra->factura_o_boleta }}</td>
                    <td>{{ $compra->proveedor->nombre }}</td>
                    <td>{{ $compra->estado }}</td>
                    <td>
                        <!-- Aquí puedes agregar botones para editar o eliminar -->
                        <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

