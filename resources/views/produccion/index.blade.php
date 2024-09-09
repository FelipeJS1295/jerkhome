@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-white text-center my-4">Órdenes de Trabajo</h1>

    <!-- Botón para abrir el modal -->
    <div class="text-center mb-4">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#ordenesTrabajoModal">
            Ingresar O.T.
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ordenesTrabajoModal" tabindex="-1" aria-labelledby="ordenesTrabajoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.9);">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white" id="ordenesTrabajoModalLabel">Seleccionar Sección para Orden de Trabajo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Tarjeta de Tapicería -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-center bg-secondary text-light shadow-sm" style="cursor: pointer;" onclick="window.location='{{ route('produccion.create', ['seccion' => 'Tapiceria']) }}'">
                                <div class="card-body">
                                    <i class="fas fa-couch fa-3x mb-3"></i>
                                    <h5 class="card-title">Tapicería</h5>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta de Costura -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-center bg-secondary text-light shadow-sm" style="cursor: pointer;" onclick="window.location='{{ route('produccion.create', ['seccion' => 'Costura']) }}'">
                                <div class="card-body">
                                    <i class="fas fa-cut fa-3x mb-3"></i>
                                    <h5 class="card-title">Costura</h5>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta de Esqueletería Corte -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-center bg-secondary text-light shadow-sm" style="cursor: pointer;" onclick="window.location='{{ route('produccion.create', ['seccion' => 'Esqueleteria Corte']) }}'">
                                <div class="card-body">
                                    <i class="fas fa-industry fa-3x mb-3"></i> <!-- Icono agregado -->
                                    <h5 class="card-title">Esqueletería Corte</h5>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta de Esqueletería Armado -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-center bg-secondary text-light shadow-sm" style="cursor: pointer;" onclick="window.location='{{ route('produccion.create', ['seccion' => 'Esqueleteria Armado']) }}'">
                                <div class="card-body">
                                    <i class="fas fa-tools fa-3x mb-3"></i>
                                    <h5 class="card-title">Esqueletería Armado</h5>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta de Esqueletería Completo -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-center bg-secondary text-light shadow-sm" style="cursor: pointer;" onclick="window.location='{{ route('produccion.create', ['seccion' => 'Esqueleteria Completo']) }}'">
                                <div class="card-body">
                                    <i class="fas fa-check fa-3x mb-3"></i>
                                    <h5 class="card-title">Esqueletería Completo</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Componente de Navs & Tabs -->
    
    <form action="{{ route('produccion.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="trabajador_id" class="text-white">Filtrar por Trabajador</label>
                    <select name="trabajador_id" id="trabajador_id" class="form-control">
                        <option value="">Seleccione un trabajador</option>
                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>
    
    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <h3 class="text-white">Lista de Órdenes de Trabajo</h3>

            <!-- Navs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="todas-tab" data-bs-toggle="tab" href="#todas" role="tab" aria-controls="todas" aria-selected="true">Todas</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tapiceria-tab" data-bs-toggle="tab" href="#tapiceria" role="tab" aria-controls="tapiceria" aria-selected="false">Tapicería</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="costura-tab" data-bs-toggle="tab" href="#costura" role="tab" aria-controls="costura" aria-selected="false">Costura</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="esqueleteria-tab" data-bs-toggle="tab" href="#esqueleteria" role="tab" aria-controls="esqueleteria" aria-selected="false">Esqueletería</a>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="todas" role="tabpanel" aria-labelledby="todas-tab">
                    <!-- Tabla de todas las órdenes -->
                    <table class="table table-dark table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Número de OT</th>
                                <th>Fecha</th>
                                <th>Sección</th>
                                <th>Trabajador</th>
                                <th>Producto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordenesTrabajo as $orden)
                                <tr>
                                    <td>{{ $orden->numero_ot }}</td>
                                    <td>{{ $orden->fecha }}</td>
                                    <td>{{ $orden->seccion }}</td>
                                    <td>{{ $orden->trabajador->nombre }}</td>
                                    <td>{{ $orden->producto->nombre }}</td>
                                    <td>
                                        <a href="{{ route('produccion.edit', $orden->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('produccion.destroy', $orden->id) }}" method="POST" style="display:inline;">
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

                <div class="tab-pane fade" id="tapiceria" role="tabpanel" aria-labelledby="tapiceria-tab">
                    <!-- Tabla de órdenes de Tapicería -->
                    <table class="table table-dark table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Número de OT</th>
                                <th>Fecha</th>
                                <th>Sección</th>
                                <th>Trabajador</th>
                                <th>Producto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordenesTrabajo->where('seccion', 'Tapiceria') as $orden)
                                <tr>
                                    <td>{{ $orden->numero_ot }}</td>
                                    <td>{{ $orden->fecha }}</td>
                                    <td>{{ $orden->seccion }}</td>
                                    <td>{{ $orden->trabajador->nombre }}</td>
                                    <td>{{ $orden->producto->nombre }}</td>
                                    <td>
                                        <a href="{{ route('produccion.edit', $orden->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('produccion.destroy', $orden->id) }}" method="POST" style="display:inline;">
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

                <div class="tab-pane fade" id="costura" role="tabpanel" aria-labelledby="costura-tab">
                    <!-- Tabla de órdenes de Costura -->
                    <table class="table table-dark table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Número de OT</th>
                                <th>Fecha</th>
                                <th>Sección</th>
                                <th>Trabajador</th>
                                <th>Producto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordenesTrabajo->where('seccion', 'Costura') as $orden)
                                <tr>
                                    <td>{{ $orden->numero_ot }}</td>
                                    <td>{{ $orden->fecha }}</td>
                                    <td>{{ $orden->seccion }}</td>
                                    <td>{{ $orden->trabajador->nombre }}</td>
                                    <td>{{ $orden->producto->nombre }}</td>
                                    <td>
                                        <a href="{{ route('produccion.edit', $orden->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('produccion.destroy', $orden->id) }}" method="POST" style="display:inline;">
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

                <div class="tab-pane fade" id="esqueleteria" role="tabpanel" aria-labelledby="esqueleteria-tab">
                    <!-- Tabla de órdenes de Esqueletería -->
                    <table class="table table-dark table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Número de OT</th>
                                <th>Fecha</th>
                                <th>Sección</th>
                                <th>Trabajador</th>
                                <th>Producto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordenesTrabajo->where('seccion', 'Esqueleteria') as $orden)
                                <tr>
                                    <td>{{ $orden->numero_ot }}</td>
                                    <td>{{ $orden->fecha }}</td>
                                    <td>{{ $orden->seccion }}</td>
                                    <td>{{ $orden->trabajador->nombre }}</td>
                                    <td>{{ $orden->producto->nombre }}</td>
                                    <td>
                                        <a href="{{ route('produccion.edit', $orden->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('produccion.destroy', $orden->id) }}" method="POST" style="display:inline;">
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
        </div>
    </div>
</div>
@endsection