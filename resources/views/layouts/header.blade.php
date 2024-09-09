<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">JERK HOME</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="ordenesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Órdenes de Compra
                </a>
                <div class="dropdown-menu" aria-labelledby="ordenesDropdown">
                    <a class="dropdown-item" href="{{ route('ordenes-de-compra.index') }}">Listado de Órdenes</a>
                    <a class="dropdown-item" href="{{ route('excel.import.form') }}">Carga de OC</a>
                    <a class="dropdown-item" href="{{ route('ordenes-de-compra.maestra') }}">Maestra</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="ordenesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mantenedores
                </a>
                <div class="dropdown-menu" aria-labelledby="ordenesDropdown">
                    <a class="dropdown-item" href="{{ route('clientes.index') }}">Clientes</a>
                    <a class="dropdown-item" href="{{ route('productos.index') }}">Productos</a>
                    <a class="dropdown-item" href="{{ route('proveedores.index') }}">Proveedores</a>
                    <a class="dropdown-item" href="{{ route('insumos.index') }}">Insumos</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="ordenesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Insumos
                </a>
                <div class="dropdown-menu" aria-labelledby="ordenesDropdown">
                    <a class="dropdown-item" href="{{ route('compras.index') }}">Insumos</a>
                </div>
            </li>
            
        </ul>
    </div>
</nav>
