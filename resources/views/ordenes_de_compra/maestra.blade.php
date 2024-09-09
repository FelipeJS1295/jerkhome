@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Maestra de Órdenes de Compra</h1>
        <button onclick="printContent()" class="btn btn-primary">Imprimir</button>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body" id="printableArea">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        @foreach ($fechas as $fecha)
                            <th>{{ $fecha }}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientesConOrdenes as $clienteId => $productos)
                        @php
                            $cliente = App\Models\Cliente::find($clienteId);
                        @endphp
                        <tr>
                            <td colspan="{{ $fechas->count() + 2 }}" class="bg-secondary text-light">
                                {{ $cliente->nombre ?? 'Cliente Desconocido' }}
                            </td>
                        </tr>
                        @foreach ($productos as $productoId => $ordenesPorFecha)
                            @php
                                $producto = App\Models\Producto::find($productoId);
                            @endphp
                            <tr>
                                <td>{{ $producto->nombre ?? 'Producto Desconocido' }}</td>
                                @foreach ($fechas as $fecha)
                                    <td>{{ $ordenesPorFecha->get($fecha, collect())->sum('unidades') }}</td>
                                @endforeach
                                <td>{{ $ordenesPorFecha->flatten()->sum('unidades') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{ $fechas->count() + 1 }}" class="text-end bg-secondary text-light"><strong>Total por {{ $cliente->nombre ?? 'Cliente Desconocido' }}</strong></td>
                            <td class="bg-secondary text-light"><strong>{{ $productos->flatten(2)->sum('unidades') }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        @foreach ($totalesPorFecha as $total)
                            <th>{{ $total }}</th>
                        @endforeach
                        <th>{{ $totalGeneral }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    function printContent() {
        var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.body.innerHTML;

        var printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Imprimir</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
        printWindow.document.write('table, th, td { border: 1px solid black; }');
        printWindow.document.write('th, td { padding: 8px; text-align: left; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
@endsection
