@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Órdenes de Compra</h1>
        <a href="{{ route('ordenes-de-compra.create') }}" class="btn btn-primary">Crear Nueva Orden de Compra</a>
    </div>

    <!-- Mostrar errores -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Mostrar mensajes de éxito -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Formulario de filtros -->
    <div class="card bg-dark text-light shadow rounded mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ordenes-de-compra.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="orden_de_compra" class="form-label">Orden de Compra</label>
                        <input type="text" name="orden_de_compra" id="orden_de_compra" class="form-control bg-secondary text-light" placeholder="Orden de Compra" value="{{ request('orden_de_compra') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input type="text" name="cliente" id="cliente" class="form-control bg-secondary text-light" placeholder="Cliente" value="{{ request('cliente') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control bg-secondary text-light" placeholder="Fecha" value="{{ request('fecha') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-control bg-secondary text-light">
                            <option value="">Estado</option>
                            <option value="nuevo" {{ request('estado') == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                            <option value="en proceso" {{ request('estado') == 'en proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="terminado" {{ request('estado') == 'terminado' ? 'selected' : '' }}>Terminado</option>
                            <option value="despachado" {{ request('estado') == 'despachado' ? 'selected' : '' }}>Despachado</option>
                            <option value="devolucion" {{ request('estado') == 'devolucion' ? 'selected' : '' }}>Devolución</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-danger">Filtrar</button>
                    <a href="{{ route('ordenes-de-compra.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulario para actualizar el estado de órdenes seleccionadas -->
    <div class="form-group mb-4">
        <label for="nuevo_estado" class="form-label text-light">Cambiar estado a:</label>
        <div class="input-group">
            <select name="nuevo_estado" id="nuevo_estado" class="form-control">
                <option value="nuevo">Nuevo</option>
                <option value="en proceso">En proceso</option>
                <option value="terminado">Terminado</option>
                <option value="despachado">Despachado</option>
                <option value="devolucion">Devolución</option>
            </select>
            <button type="button" class="btn btn-primary" id="cambiarEstadoBtn">Actualizar Estado</button>
        </div>
    </div>

    <!-- Lista de órdenes en tabla -->
    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Orden de Compra</th>
                    <th>Fecha de Compra</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Monto</th>
                    <th>Fecha de Envío</th>
                    <th>Unidades</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordenes as $orden)
                <tr>
                    <td><input type="checkbox" class="ordenCheckbox" value="{{ $orden->id }}"></td>
                    <td>{{ $orden->orden_de_compra }}</td>
                    <td>{{ \Carbon\Carbon::parse($orden->fecha)->format('d-m-Y') }}</td>
                    <td>{{ $orden->cliente->nombre }}</td>
                    <td>{{ $orden->producto->nombre }}</td>
                    <td>${{ number_format($orden->monto, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($orden->fecha_envio)->format('d-m-Y') }}</td>
                    <td>{{ $orden->unidades }}</td>
                    <td>{{ $orden->estado_orden }}</td>
                    <td>
                        <a href="{{ route('ordenes-de-compra.edit', $orden->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('ordenes-de-compra.destroy', $orden->id) }}" method="POST" style="display:inline;">
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

<!-- Script para manejar la actualización de estado -->
<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('.ordenCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.getElementById('cambiarEstadoBtn').addEventListener('click', function() {
        let seleccionados = [];
        document.querySelectorAll('.ordenCheckbox:checked').forEach((checkbox) => {
            seleccionados.push(checkbox.value);
        });

        if (seleccionados.length > 0) {
            let nuevoEstado = document.getElementById('nuevo_estado').value;

            fetch('{{ route("ordenes-de-compra.updateEstadoMultiple") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ordenes: seleccionados,
                        nuevo_estado: nuevoEstado
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al actualizar el estado');
                    }
                });
        } else {
            alert('Por favor, selecciona al menos una orden');
        }
    });
</script>
@endsection
