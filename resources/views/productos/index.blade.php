@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">Agregar Producto</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Esqueleto C</th>
                <th>Esqueleto A</th>
                <th>Esqueleto</th>
                <th>Costura</th>
                <th>Tapicería</th>
                <th>Corte</th>
                <th>Armado</th>
                <th>Completo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->sku }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->esqueletoc }}</td>
                <td>{{ $producto->esqueletoa }}</td>
                <td>{{ $producto->esqueleto }}</td>
                <td>{{ $producto->ccostura }}</td>
                <td>{{ $producto->ctapiceria }}</td>
                <td>{{ $producto->ccorte }}</td>
                <td>{{ $producto->carmado }}</td>
                <td>{{ $producto->ccompleto }}</td>
                <td>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
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
