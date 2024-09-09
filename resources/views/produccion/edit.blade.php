@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Editar Orden de Trabajo</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('produccion.update', $orden->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="numero_ot" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Número de OT</label>
                    <input type="text" class="form-control bg-secondary text-light" id="numero_ot" name="numero_ot" value="{{ $orden->numero_ot }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha</label>
                    <input type="date" class="form-control bg-secondary text-light" id="fecha" name="fecha" value="{{ $orden->fecha }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="seccion" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Sección</label>
                    <select class="form-control bg-secondary text-light" id="seccion" name="seccion" required>
                        <option value="Tapiceria" {{ $orden->seccion == 'Tapiceria' ? 'selected' : '' }}>Tapicería</option>
                        <option value="Costura" {{ $orden->seccion == 'Costura' ? 'selected' : '' }}>Costura</option>
                        <option value="Esqueleteria Corte" {{ $orden->seccion == 'Esqueleteria Corte' ? 'selected' : '' }}>Esqueletería Corte</option>
                        <option value="Esqueleteria Armado" {{ $orden->seccion == 'Esqueleteria Armado' ? 'selected' : '' }}>Esqueletería Armado</option>
                        <option value="Esqueleteria Completo" {{ $orden->seccion == 'Esqueleteria Completo' ? 'selected' : '' }}>Esqueletería Completo</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="trabajador_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Trabajador</label>
                    <select class="form-control bg-secondary text-light" id="trabajador_id" name="trabajador_id" required>
                        @foreach($trabajadores as $trabajador)
                            @if(($orden->seccion == 'Tapiceria' && $trabajador->cargo == 'Tapicero') || 
                                ($orden->seccion == 'Costura' && $trabajador->cargo == 'Costura') || 
                                ($orden->seccion == 'Esqueleteria Corte' && $trabajador->cargo == 'Esqueleteria') || 
                                ($orden->seccion == 'Esqueleteria Armado' && $trabajador->cargo == 'Esqueleteria') || 
                                ($orden->seccion == 'Esqueleteria Completo' && $trabajador->cargo == 'Esqueleteria'))
                                <option value="{{ $trabajador->id }}" {{ $orden->trabajador_id == $trabajador->id ? 'selected' : '' }}>{{ $trabajador->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="producto_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Producto</label>
                    <select class="form-control bg-secondary text-light" id="producto_id" name="producto_id" required>
                        @foreach($productos as $producto)
                            @if(($orden->seccion == 'Tapiceria' && $producto->nombre) || 
                                ($orden->seccion == 'Costura' && $producto->nombre) || 
                                ($orden->seccion == 'Esqueleteria Corte' && $producto->esqueletoc) || 
                                ($orden->seccion == 'Esqueleteria Armado' && $producto->esqueletoa) || 
                                ($orden->seccion == 'Esqueleteria Completo' && $producto->esqueleto))
                                <option value="{{ $producto->id }}" {{ $orden->producto_id == $producto->id ? 'selected' : '' }}>
                                    {{ $orden->seccion == 'Tapiceria' || $orden->seccion == 'Costura' ? $producto->nombre : 
                                       ($orden->seccion == 'Esqueleteria Corte' ? $producto->esqueletoc : 
                                       ($orden->seccion == 'Esqueleteria Armado' ? $producto->esqueletoa : 
                                       $producto->esqueleto)) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Actualizar</button>
            </form>
        </div>
    </div>
</div>
@endsection


