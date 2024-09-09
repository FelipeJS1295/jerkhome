@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Inventario de Insumos</h1>
        <a href="{{ route('inventario_insumos.create') }}" class="btn btn-primary mb-3">Asignar Nuevo Insumo</a>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre del Insumo</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventario as $item)
                    <tr>
                        <td>{{ $item->insumo->nombre }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>
                            <a href="{{ route('inventario_insumos.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('inventario_insumos.destroy', $item->id) }}" method="POST" style="display:inline;">
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
