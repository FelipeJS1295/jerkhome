@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Crear Nuevo Insumo</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('insumos.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="proveedor_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Proveedor:</label>
                    <select id="proveedor_id" name="proveedor_id" class="form-control bg-secondary text-light" required>
                        <option value="">Selecciona un proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="sku_padre" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">SKU Padre:</label>
                    <input type="text" id="sku_padre" name="sku_padre" class="form-control bg-secondary text-light" value="{{ old('sku_padre') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="sku_jerk" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">SKU Jerk:</label>
                    <input type="text" id="sku_jerk" name="sku_jerk" class="form-control bg-secondary text-light" value="{{ old('sku_jerk') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control bg-secondary text-light" value="{{ old('nombre') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="unidad_de_medida" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Unidad de Medida:</label>
                    <select id="unidad_de_medida" name="unidad_de_medida" class="form-control bg-secondary text-light" required>
                        <option value="metros" {{ old('unidad_de_medida') == 'metros' ? 'selected' : '' }}>Metros</option>
                        <option value="unidades" {{ old('unidad_de_medida') == 'unidades' ? 'selected' : '' }}>Unidades</option>
                        <option value="centimetros" {{ old('unidad_de_medida') == 'centimetros' ? 'selected' : '' }}>Centímetros</option>
                        <option value="Kg" {{ old('unidad_de_medida') == 'Kg' ? 'selected' : '' }}>Kg</option>
                        <option value="Lt" {{ old('unidad_de_medida') == 'Lt' ? 'selected' : '' }}>Lt</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="precio_unitario" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Precio Unitario:</label>
                    <input type="number" id="precio_unitario" name="precio_unitario" class="form-control bg-secondary text-light" step="0.01" value="{{ old('precio_unitario') }}" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection


