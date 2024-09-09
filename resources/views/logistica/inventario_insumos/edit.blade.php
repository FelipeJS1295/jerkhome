@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Insumo en Inventario</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventario_insumos.update', $inventario->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="insumo_id" class="form-label">Insumo</label>
                <select class="form-select" id="insumo_id" name="insumo_id" required disabled>
                    <option value="{{ $inventario->insumo->id }}">{{ $inventario->insumo->nombre }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ $inventario->cantidad }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Inventario</button>
        </form>
    </div>
@endsection
