@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Crear Nuevo Producto</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="sku" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">SKU</label>
                    <input type="text" class="form-control bg-secondary text-light" id="sku" name="sku" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Nombre</label>
                    <input type="text" class="form-control bg-secondary text-light" id="nombre" name="nombre" required>
                </div>
                <div class="form-group mb-3">
                    <label for="esqueletoc" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Esqueleto C</label>
                    <input type="text" class="form-control bg-secondary text-light" id="esqueletoc" name="esqueletoc">
                </div>
                <div class="form-group mb-3">
                    <label for="esqueletoa" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Esqueleto A</label>
                    <input type="text" class="form-control bg-secondary text-light" id="esqueletoa" name="esqueletoa">
                </div>
                <div class="form-group mb-3">
                    <label for="esqueleto" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Esqueleto</label>
                    <input type="text" class="form-control bg-secondary text-light" id="esqueleto" name="esqueleto">
                </div>
                <div class="form-group mb-3">
                    <label for="ccostura" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Costo Costura</label>
                    <input type="number" class="form-control bg-secondary text-light" id="ccostura" name="ccostura">
                </div>
                <div class="form-group mb-3">
                    <label for="ctapiceria" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Costo Tapicería</label>
                    <input type="number" class="form-control bg-secondary text-light" id="ctapiceria" name="ctapiceria">
                </div>
                <div class="form-group mb-3">
                    <label for="ccorte" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Costo Corte</label>
                    <input type="number" class="form-control bg-secondary text-light" id="ccorte" name="ccorte">
                </div>
                <div class="form-group mb-3">
                    <label for="carmado" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Costo Armado</label>
                    <input type="number" class="form-control bg-secondary text-light" id="carmado" name="carmado">
                </div>
                <div class="form-group mb-3">
                    <label for="ccompleto" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Costo Completo</label>
                    <input type="number" class="form-control bg-secondary text-light" id="ccompleto" name="ccompleto">
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
