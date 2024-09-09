@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 text-light mb-4">Ficha del Trabajador</h1>
    
    <div class="card bg-dark text-light shadow rounded mb-4">
        <div class="card-body">
            <h4 class="text-primary mb-3">Información Personal</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nombre:</strong> {{ $trabajador->nombre }}</p>
                    <p><strong>Apellido:</strong> {{ $trabajador->apellido }}</p>
                    <p><strong>RUT:</strong> {{ $trabajador->rut }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ $trabajador->fecha_nacimiento }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Dirección:</strong> {{ $trabajador->direccion }}</p>
                    <p><strong>Teléfono:</strong> {{ $trabajador->telefono }}</p>
                    <p><strong>Email:</strong> {{ $trabajador->email }}</p>
                    <p><strong>AFP:</strong> {{ $trabajador->afp }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Isapre/Fonasa:</strong> {{ $trabajador->isapre_fonasa }}</p>
                    <p><strong>Cargo:</strong> {{ $trabajador->cargo }}</p>
                    <p><strong>Sueldo:</strong> {{ $trabajador->sueldo }}</p>
                    <p><strong>Fecha de Ingreso:</strong> {{ $trabajador->fecha_ingreso }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-light shadow rounded mb-4">
        <div class="card-body">
            <h4 class="text-primary mb-3">Tiempo Personal</h4>
            @if($trabajador->tiemposPersonales->isEmpty())
                <p>No hay registros de tiempo personal.</p>
            @else
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trabajador->tiemposPersonales as $tiempo)
                            <tr>
                                <td>{{ $tiempo->tipo }}</td>
                                <td>{{ $tiempo->fecha_inicio }}</td>
                                <td>{{ $tiempo->fecha_fin }}</td>
                                <td>{{ $tiempo->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="card bg-dark text-light shadow rounded mb-4">
        <div class="card-body">
            <h4 class="text-primary mb-3">Evaluaciones</h4>
            @if($trabajador->evaluaciones->isEmpty())
                <p>No hay registros de evaluaciones.</p>
            @else
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Comentario</th>
                            <th>Puntuación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trabajador->evaluaciones as $evaluacion)
                            <tr>
                                <td>{{ $evaluacion->fecha }}</td>
                                <td>{{ $evaluacion->comentario }}</td>
                                <td>{{ $evaluacion->puntuacion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="card bg-dark text-light shadow rounded mb-4">
        <div class="card-body">
            <h4 class="text-primary mb-3">Producción</h4>
            <form method="GET" action="{{ route('trabajadores.show', $trabajador->id) }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_desde" class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control bg-secondary text-light" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control bg-secondary text-light" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="numero_ot" class="form-label">Número de OT</label>
                            <input type="text" class="form-control bg-secondary text-light" id="numero_ot" name="numero_ot" value="{{ request('numero_ot') }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>

            @if($producciones->isEmpty())
                <p>No hay registros de producción.</p>
            @else
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Número de OT</th>
                            <th>Producto</th>
                            <th>Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($producciones as $produccion)
                            <tr>
                                <td>{{ $produccion->fecha }}</td>
                                <td>{{ $produccion->numero_ot }}</td>
                                <td>{{ $produccion->producto->nombre }}</td>
                                <td>
                                    @if($trabajador->cargo == 'Tapicero')
                                        {{ $produccion->producto->ctapiceria }}
                                    @elseif($trabajador->cargo == 'Costura')
                                        {{ $produccion->producto->ccostura }}
                                    @elseif($trabajador->cargo == 'Cortador')
                                        {{ $produccion->producto->ccorte }}
                                    @elseif($trabajador->cargo == 'Armador')
                                        {{ $produccion->producto->carmado }}
                                    @elseif($trabajador->cargo == 'Esqueletero')
                                        {{ $produccion->producto->ccompleto }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><strong>Total de Producción:</strong> {{ $totalProduccion }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total de Unidades:</strong> {{ $totalUnidades }}</p>
                    </div>
                </div>
                
                <!-- Botón para imprimir la producción -->
                <div class="mt-4">
                    <a href="{{ route('trabajadores.imprimirProduccion', $trabajador->id) }}" target="_blank" class="btn btn-success">Imprimir Producción</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
