@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-white text-center my-4">Crear Orden de Trabajo - {{ $seccion }}</h1>

    <!-- Mostrar mensaje de éxito -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('produccion.store') }}" method="POST">
                @csrf
                <input type="hidden" name="seccion" value="{{ $seccion }}">
                <div class="form-group mb-3">
                    <label for="numero_ot" class="form-label">Número de OT</label>
                    <input type="text" class="form-control" id="numero_ot" name="numero_ot" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                <div class="form-group mb-3">
                    <label for="trabajador_id" class="form-label">Trabajador</label>
                    <select class="form-control" id="trabajador_id" name="trabajador_id" required>
                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="producto_id" class="form-label">Producto</label>
                    <select class="form-control" id="producto_id" name="producto_id" required>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection