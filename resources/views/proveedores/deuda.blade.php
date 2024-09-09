@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="summary">
            <h1>RESUMEN PROVEEDOR: {{ $proveedor->nombre }}</h1>
            <p>MONTO TOTAL DEUDA: {{ number_format($totalDeuda, 0, ',', '.') }}</p>
            <p>MONTO TOTAL PAGOS: {{ number_format($totalPagos, 0, ',', '.') }}</p>
        </div>
        
        <div class="documents">
            <h2>DOCUMENTOS:</h2>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Numero de Documento</th>
                        <th>Monto</th>
                        <th>Fecha documento</th>
                        <th>Fecha Vencimiento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos as $documento)
                        <tr>
                            <td>{{ $documento->numero_documento }}</td>
                            <td>{{ number_format($documento->total, 0, ',', '.') }}</td>
                            <td>{{ $documento->fecha_documento }}</td>
                            <td>{{ $documento->vencimiento }}</td>
                            <td>{{ $documento->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="payments">
            <h2>PAGOS:</h2>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Tipo de pago</th>
                        <th>Fecha</th>
                        <th>Numero del pago</th>
                        <th>Monto del pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $pago->tipo_pago }}</td>
                            <td>{{ $pago->fecha_pago }}</td>
                            <td>{{ $pago->numero_pago }}</td>
                            <td>{{ number_format($pago->monto, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<style>
    body {
        background-color: #000;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .container {
        padding: 20px;
    }

    .summary {
        border: 2px solid #fff;
        padding: 20px;
        margin-bottom: 20px;
        text-align: left;
        background-color: #000;
        color: #fff;
    }

    .summary h1 {
        margin: 0;
        padding: 10px 0;
    }

    .summary p {
        margin: 5px 0;
        padding: 5px 0;
    }

    .documents, .payments {
        margin-top: 20px;
    }

    .documents h2, .payments h2 {
        margin: 0 0 10px 0;
        padding: 10px 0;
        background-color: #333;
        color: #fff;
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 18px;
        text-align: left;
        background-color: #444;
    }

    .styled-table th, .styled-table td {
        padding: 12px 15px;
        border: 1px solid #fff;
    }

    .styled-table thead tr {
        background-color: #333;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #fff;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #555;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #fff;
    }
</style>

