@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Historial de Pagos</h1>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <h2>Documento: {{ $documento->numero_documento }}</h2>
            <h3>Proveedor: {{ $documento->proveedor->nombre }}</h3>
            <h3>Total Restante: {{ number_format($documento->total - $totalPagado, 0, ',', '.') }}</h3>
            <h3>Total Pagado: {{ number_format($totalPagado, 0, ',', '.') }}</h3>

            <table class="table table-dark table-striped mt-4">
                <thead>
                    <tr>
                        <th>Tipo de Pago</th>
                        <th>Fecha de Pago</th>
                        <th>Número de Pago</th>
                        <th>Monto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documento->pagos as $pago)
                        <tr>
                            <td>{{ $pago->tipo_pago }}</td>
                            <td>{{ $pago->fecha_pago }}</td>
                            <td>{{ $pago->numero_pago }}</td>
                            <td>{{ number_format($pago->monto, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('documentos.mostrarPago', $documento->id) }}" class="btn btn-danger mb-3">Registrar Pago</a>

            @if(!$documento->pagado)
                <form action="{{ route('documentos.finalizar', $documento->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Finalizar</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
