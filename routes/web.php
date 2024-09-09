<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OrdenDeCompraController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\TiempoPersonalController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ContabilidadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\InventarioInsumoController;

// Redirigir a la página de login
Route::get('/', function () {
    return redirect('/login');
});

// Ruta para el login y logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('clientes', ClienteController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('ordenes-de-compra', OrdenDeCompraController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('insumos', InsumoController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('trabajadores', TrabajadorController::class);

    // Rutas para la importación de Excel
    Route::get('import-excel', [ExcelImportController::class, 'showImportForm'])->name('excel.import.form');
    Route::post('import-excel', [ExcelImportController::class, 'import'])->name('excel.import');
    Route::post('upload-excel', [ExcelImportController::class, 'store'])->name('excel.upload');
    Route::post('ordenes-de-compra/update-estado-multiple', [OrdenDeCompraController::class, 'updateEstadoMultiple'])->name('ordenes-de-compra.updateEstadoMultiple');
    Route::get('maestra', [OrdenDeCompraController::class, 'maestra'])->name('ordenes-de-compra.maestra');

    // Rutas específicas para producción
    Route::get('/produccion', [ProduccionController::class, 'index'])->name('produccion.index');
    Route::get('/produccion/create', [ProduccionController::class, 'create'])->name('produccion.create');
    Route::post('/produccion', [ProduccionController::class, 'store'])->name('produccion.store');
    Route::get('/produccion/{id}/edit', [ProduccionController::class, 'edit'])->name('produccion.edit');
    Route::put('/produccion/{id}', [ProduccionController::class, 'update'])->name('produccion.update');
    Route::delete('/produccion/{id}', [ProduccionController::class, 'destroy'])->name('produccion.destroy');

    // Rutas específicas para RRHH
    Route::prefix('rrhh')->group(function () {
        Route::resource('tiempo_personal', TiempoPersonalController::class);
        Route::resource('evaluacion', EvaluacionController::class);
        Route::get('trabajadores/{id}/imprimir-produccion', [TrabajadorController::class, 'imprimirProduccion'])->name('trabajadores.imprimirProduccion');
    });

    // Rutas específicas para Finanzas
    Route::prefix('finanzas')->group(function () {
        Route::resource('contabilidad', ContabilidadController::class);
        Route::resource('documentos', DocumentoController::class);
    });

    // Ruta para obtener insumos de un proveedor
    Route::get('/proveedores/{proveedor}/insumos', [ProveedorController::class, 'getInsumos']);
    
    Route::patch('documentos/{id}/pagar', [DocumentoController::class, 'pagar'])->name('documentos.pagar');
    Route::patch('documentos/{id}/corregir', [DocumentoController::class, 'corregir'])->name('documentos.corregir');
    Route::post('documentos/{id}/pagar', [DocumentoController::class, 'pagar'])->name('documentos.pagar');
    Route::get('documentos/{id}/pagos', [PagoController::class, 'index'])->name('documentos.pagos.index');
    Route::post('documentos/{id}/pagos', [PagoController::class, 'store'])->name('documentos.pagos.store');
    Route::get('documentos/{id}/pagar', [DocumentoController::class, 'mostrarPago'])->name('documentos.mostrarPago');
    Route::get('documentos/{id}/historial', [DocumentoController::class, 'historialPagos'])->name('documentos.historial');
    Route::delete('pagos/{id}', [PagoController::class, 'destroy'])->name('pagos.destroy');
    Route::post('documentos/{id}/registrarPago', [DocumentoController::class, 'registrarPago'])->name('documentos.registrarPago');
    Route::patch('documentos/{id}/finalizar', [DocumentoController::class, 'finalizar'])->name('documentos.finalizar');
    Route::get('proveedores/{rut}/deuda', [ProveedorController::class, 'verDeuda'])->name('proveedores.deuda');
    Route::resource('inventario_insumos', InventarioInsumoController::class);
});