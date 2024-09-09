@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Carga Masiva de Órdenes de Compra</h1>
    <form action="{{ route('ordenes-de-compra.cargaMasiva') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="archivo">Archivo Excel</label>
            <input type="file" class="form-control" id="archivo" name="archivo" required>
        </div>
        <button type="submit" class="btn btn-primary">Cargar</button>
    </form>
</div>
@endsection
