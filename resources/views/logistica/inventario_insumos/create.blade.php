@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Asignar Insumo al Inventario</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventario_insumos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="insumo_id" class="form-label">Insumo</label>
                <select class="form-select" id="insumo_id" name="insumo_id" required>
                    <option value="">Seleccione un insumo</option>
                    @foreach($insumos as $insumo)
                        <option value="{{ $insumo->id }}">{{ $insumo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Asignar al Inventario</button>
        </form>
    </div>
@endsection
