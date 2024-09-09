@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Editar Tiempo Personal</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('rrhh.tiempo_personal.update', $tiempoPersonal->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="trabajador_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Trabajador</label>
                    <select id="trabajador_id" name="trabajador_id" class="form-control bg-secondary text-light" required>
                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}" {{ $trabajador->id == $tiempoPersonal->trabajador_id ? 'selected' : '' }}>{{ $trabajador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="tipo" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Tipo</label>
                    <input type="text" id="tipo" name="tipo" class="form-control bg-secondary text-light" value="{{ $tiempoPersonal->tipo }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_inicio" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control bg-secondary text-light" value="{{ $tiempoPersonal->fecha_inicio }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_fin" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha de Fin</label>
                    <input type="date" id="fecha_fin"
