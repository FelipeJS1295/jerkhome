@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Documentos</h1>

    <div class="card bg-dark text-light shadow rounded mb-4">
        <div class="card-body">
            <form action="{{ route('documentos.index') }}" method="GET" class="form-inline">
                <div class="form-group mr-2 mb-2">
                    <input type="text" name="numero_documento" class="form-control" placeholder="Número de Documento" value="{{ request()->numero_documento }}">
                </div>
                <div class="form-group mr-2 mb-2">
                    <input type="date" name="fecha_documento" class="form-control" placeholder="Fecha de Documento" value="{{ request()->fecha_documento }}">
                </div>
                <div class="form-group mr-2 mb-2">
                    <input type="date" name="vencimiento" class="form-control" placeholder="Fecha de Vencimiento" value="{{ request()->vencimiento }}">
                </div>
                <div class="form-group mr-2 mb-2">
                    <select name="proveedor_id" class="form-control">
                        <option value="">Seleccione Proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ request()->proveedor_id == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mr-2 mb-2">
                    <select name="estado" class="form-control">
                        <option value="">Estado</option>
                        <option value="pagados" {{ request()->estado == 'pagados' ? 'selected' : '' }}>Pagados</option>
                        <option value="no_pagados" {{ request()->estado == 'no_pagados' ? 'selected' : '' }}>No Pagados</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger mr-2 mb-2">Buscar</button>
                <a href="{{ route('documentos.index') }}" class="btn btn-secondary mr-2 mb-2">Limpiar</a>
                <a href="{{ route('documentos.create') }}" class="btn btn-danger mb-2">Registrar Documento</a>
            </form>
        </div>
    </div>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th>Número</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Vencimiento</th>
                <th>Estado</th>
                <th>Total</th>
                <th>Total Pagado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentos as $documento)
                @php
                    $diasRestantes = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($documento->vencimiento), false);
                    $diasRestantesEnteros = intval($diasRestantes);
                    $claseFila = '';

                    if ($diasRestantesEnteros > 5) {
                        $claseFila = 'table-success';
                    } elseif ($diasRestantesEnteros >= 0 && $diasRestantesEnteros <= 5) {
                        $claseFila = 'table-warning';
                    } elseif ($diasRestantesEnteros < 0 && $diasRestantesEnteros >= -15) {
                        $claseFila = 'table-danger';
                    } elseif ($diasRestantesEnteros < -15) {
                        $claseFila = 'table-danger titilar';
                    }
                @endphp
                <tr class="{{ $claseFila }}">
                    <td>{{ $documento->numero_documento }}</td>
                    <td>{{ $documento->proveedor->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($documento->fecha_documento)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($documento->vencimiento)->format('d/m/Y') }}</td>
                    <td>
                        @if ($diasRestantesEnteros > 0)
                            Faltan {{ $diasRestantesEnteros }} días
                        @elseif ($diasRestantesEnteros == 0)
                            Pagar hoy
                        @else
                            Atraso de {{ abs($diasRestantesEnteros) }} días
                        @endif
                    </td>
                    <td>{{ number_format($documento->total, 0, ',', '.') }}</td>
                    <td>{{ number_format($documento->pagos->sum('monto'), 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('documentos.historial', $documento->id) }}" class="btn btn-info btn-sm">Historial</a>
                        @if($documento->pagos->count() == 0)
                            <a href="{{ route('documentos.edit', $documento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('documentos.destroy', $documento->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $documentos->appends(request()->query())->links() }}
</div>
@endsection
