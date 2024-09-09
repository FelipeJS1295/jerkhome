@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Proveedores</h1>
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">Nuevo Proveedor</a>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                {{ $message }}
            </div>
        @endif

        <table class="table mt-2">
            <thead>
                <tr>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td><a href="{{ route('proveedores.deuda', $proveedor->rut) }}">{{ $proveedor->rut }}</a></td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->contacto }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
