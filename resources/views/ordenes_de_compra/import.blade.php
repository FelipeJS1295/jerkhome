@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Importar Órdenes de Compra</h1>
    </div>

    <div class="card bg-dark text-light shadow rounded">
        <div class="card-body">
            <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="archivo" class="form-label" style="background-color: #343a40; padding: 5px 10px; border-radius: 5px;">Seleccionar archivo</label>
                    <input type="file" class="form-control bg-secondary text-light" name="archivo" id="archivo" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Importar</button>
            </form>
        </div>
    </div>
</div>
@endsection

