@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Listado de Insumos</h1>
    <a href="{{ route('insumos.create') }}" class="btn btn-primary mb-3">Agregar Nuevo Insumo</a>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>SKU Padre</th>
                    <th>SKU Jerk</th>
                    <th>Nombre</th>
                    <th>Unidad de Medida</th>
                    <th>Precio Unitario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                    <tr>
                        <td>{{ $insumo->id }}</td>
                        <td>{{ $insumo->proveedor->nombre }}</td>
                        <td>{{ $insumo->sku_padre }}</td>
                        <td>{{ $insumo->sku_jerk }}</td>
                        <td>{{ $insumo->nombre }}</td>
                        <td>{{ $insumo->unidad_de_medida }}</td>
                        <td>${{ number_format($insumo->precio_unitario, 2) }}</td>
                        <td>
                            <a href="{{ route('insumos.edit', $insumo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" style="display:inline;">
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
</div>
@endsection
