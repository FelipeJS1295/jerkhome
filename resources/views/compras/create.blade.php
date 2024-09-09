@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Compra</h1>

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

    <form action="{{ route('compras.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="factura_o_boleta">Factura o Boleta:</label>
            <input type="text" name="factura_o_boleta" id="factura_o_boleta" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="proveedor_id">Proveedor:</label>
            <select name="proveedor_id" id="proveedor_id" class="form-control" required>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div id="insumos-container">
            <div class="form-group insumo-row">
                <label for="insumo[0][insumo_id]">Insumo:</label>
                <select name="insumo[0][insumo_id]" class="form-control insumo-select" required>
                    @foreach ($insumos as $insumo)
                        <option value="{{ $insumo->id }}" data-precio="{{ $insumo->precio_unitario }}">{{ $insumo->nombre }}</option>
                    @endforeach
                </select>
                <input type="number" name="insumo[0][cantidad]" class="form-control mt-2 cantidad" placeholder="Cantidad" required>
                <input type="hidden" name="insumo[0][precio_unitario]" class="form-control mt-2 precio_unitario">
                <input type="text" name="insumo[0][total]" class="form-control mt-2 total" placeholder="Total" readonly>
            </div>
        </div>

        <button type="button" class="btn btn-success mt-2" id="add-insumo">Agregar otro insumo</button>
        
        <button type="submit" class="btn btn-primary mt-3">Guardar Compra</button>
    </form>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let insumoCount = 1;

    document.getElementById('add-insumo').addEventListener('click', function() {
        let container = document.getElementById('insumos-container');
        let newRow = document.createElement('div');
        newRow.className = 'form-group insumo-row';
        newRow.innerHTML = `
            <label for="insumo[${insumoCount}][insumo_id]">Insumo:</label>
            <select name="insumo[${insumoCount}][insumo_id]" class="form-control insumo-select" required>
                @foreach ($insumos as $insumo)
                    <option value="{{ $insumo->id }}" data-precio="{{ $insumo->precio_unitario }}">{{ $insumo->nombre }}</option>
                @endforeach
            </select>
            <input type="number" name="insumo[${insumoCount}][cantidad]" class="form-control mt-2 cantidad" placeholder="Cantidad" required>
            <input type="hidden" name="insumo[${insumoCount}][precio_unitario]" class="form-control mt-2 precio_unitario">
            <input type="text" name="insumo[${insumoCount}][total]" class="form-control mt-2 total" placeholder="Total" readonly>
        `;
        container.appendChild(newRow);
        insumoCount++;
    });

    document.getElementById('insumos-container').addEventListener('change', function(e) {
        if (e.target.classList.contains('insumo-select')) {
            let select = e.target;
            let row = select.closest('.insumo-row');
            let precio = select.options[select.selectedIndex].dataset.precio;
            row.querySelector('.precio_unitario').value = precio;
            updateTotal(row);
        }
    });

    document.getElementById('insumos-container').addEventListener('input', function(e) {
        if (e.target.classList.contains('cantidad')) {
            let row = e.target.closest('.insumo-row');
            updateTotal(row);
        }
    });

    function updateTotal(row) {
        let cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
        let precio = parseFloat(row.querySelector('.precio_unitario').value) || 0;
        let total = cantidad * precio;
        row.querySelector('.total').value = total.toFixed(2);
    }
});
</script>
@endsection

@endsection

