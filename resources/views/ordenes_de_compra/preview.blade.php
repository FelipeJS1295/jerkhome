@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Previsualización de Órdenes de Compra</h1>
    <form action="{{ route('excel.upload') }}" method="POST">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Orden de Compra</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Monto</th>
                    <th>Fecha de Envío</th>
                    <th>Rut boleta</th>
                    <th>nombre_cliente_final</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $row)
                    <tr class="{{ $row['es_repetida'] ? 'table-warning' : '' }}">
                        <td>{{ $row['orden_de_compra'] }}</td>
                        <td>{{ $row['fecha'] }}</td>
                        <td>{{ $row['cliente'] }}</td>
                        <td>{{ $row['producto'] }}</td>
                        <td>{{ $row['monto'] }}</td>
                        <td>{{ $row['fecha_envio'] }}</td>
                        <td>{{ $row['rut'] }}</td>
                        <td>{{ $row['nombre_cliente_final'] }}</td>
                        <td>{{ $row['estado_orden'] }}</td>
                        <td>
                            @if ($row['es_repetida'])
                                <button type="button" class="btn btn-danger btn-sm eliminar-orden" data-index="{{ $index }}">Eliminar</button>
                            @else
                                <input type="checkbox" name="data[{{ $index }}][incluir]" checked>
                            @endif
                            <input type="hidden" name="data[{{ $index }}][orden_de_compra]" value="{{ $row['orden_de_compra'] }}">
                            <input type="hidden" name="data[{{ $index }}][fecha]" value="{{ $row['fecha'] }}">
                            <input type="hidden" name="data[{{ $index }}][cliente]" value="{{ $row['cliente'] }}">
                            <input type="hidden" name="data[{{ $index }}][producto]" value="{{ $row['producto'] }}">
                            <input type="hidden" name="data[{{ $index }}][monto]" value="{{ $row['monto'] }}">
                            <input type="hidden" name="data[{{ $index }}][fecha_envio]" value="{{ $row['fecha_envio'] }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Guardar Órdenes</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.eliminar-orden').forEach(function(button) {
            button.addEventListener('click', function() {
                let rowIndex = this.dataset.index;
                let row = this.closest('tr');
                row.remove();
                // Marcar la orden para no ser incluida en la carga
                document.querySelector(`input[name="data[${rowIndex}][incluir]"]`).checked = false;
            });
        });
    });
</script>
@endsection
