@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Agregar Evaluación</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('evaluacion.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="trabajador_id" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Trabajador</label>
                    <select id="trabajador_id" name="trabajador_id" class="form-control bg-secondary text-light" required>
                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control bg-secondary text-light" required>
                </div>
                <div class="form-group mb-3">
                    <label for="desempeño" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Desempeño</label>
                    <input type="number" id="desempeño" name="desempeño" class="form-control bg-secondary text-light" min="1" max="5" required>
                </div>
                <div class="form-group mb-3">
                    <label for="asistencia" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Asistencia</label>
                    <input type="number" id="asistencia" name="asistencia" class="form-control bg-secondary text-light" min="1" max="5" required>
                </div>
                <div class="form-group mb-3">
                    <label for="habilidades_tecnicas" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Habilidades Técnicas</label>
                    <input type="number" id="habilidades_tecnicas" name="habilidades_tecnicas" class="form-control bg-secondary text-light" min="1" max="5" required>
                </div>
                <div class="form-group mb-3">
                    <label for="comunicacion" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Comunicación</label>
                    <input type="number" id="comunicacion" name="comunicacion" class="form-control bg-secondary text-light" min="1" max="5" required>
                </div>
                <div class="form-group mb-3">
                    <label for="comentarios" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Comentarios</label>
                    <textarea id="comentarios" name="comentarios" class="form-control bg-secondary text-light"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="recomendaciones" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Recomendaciones</label>
                    <textarea id="recomendaciones" name="recomendaciones" class="form-control bg-secondary text-light"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
