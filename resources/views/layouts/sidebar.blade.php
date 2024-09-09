<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ route('dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>JerkHome</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard') }}" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-shopping-cart me-2"></i>Ventas</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('ordenes-de-compra.index') }}" class="dropdown-item">Ordenes de compra</a>
                    <a href="{{ route('excel.import.form') }}" class="dropdown-item">Carga Masiva</a>
                    <a href="{{ route('ordenes-de-compra.maestra') }}" class="dropdown-item">Maestra</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-users me-2"></i>RRHH</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('trabajadores.index') }}" class="dropdown-item">Trabajadores</a>
                    <a href="{{ route('tiempo_personal.index') }}" class="dropdown-item">Tiempo Personal</a>
                    <a href="{{ route('evaluacion.index') }}" class="dropdown-item">Evaluacion</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-wallet me-2"></i>Finanzas</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('contabilidad.index') }}" class="dropdown-item">Contabilidad</a>
                    <a href="#" class="dropdown-item">Facturacion</a>
                    <a href="#" class="dropdown-item">Gastos</a>
                    <a href="{{ route('documentos.index') }}" class="dropdown-item">Documentos</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-bullhorn me-2"></i>Marketing</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="#" class="dropdown-item">Eventos</a>
                    <a href="#" class="dropdown-item">Automatización de Marketing</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-industry me-2"></i>Producción</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('produccion.index') }}" class="dropdown-item">Órdenes de Trabajo</a>
                    <a href="#" class="dropdown-item">Productividad</a>
                </div>
            </div>
            <!-- Menú de Logística -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-truck me-2"></i>Logística</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="#" class="dropdown-item">Despachos</a>
                    <a href="{{ route('inventario_insumos.index') }}" class="dropdown-item">Inventario insumos</a>
                    <a href="#" class="dropdown-item">Productos terminados</a>
                </div>
            </div>
        </div>
    </nav>
</div>

