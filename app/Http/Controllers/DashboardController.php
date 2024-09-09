<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenDeCompra;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;

        // Total unidades del mes
        $totalUnidadesMes = OrdenDeCompra::whereMonth('fecha_envio', $currentMonth)->sum('unidades');

        // Total monto del mes
        $totalMontoMes = OrdenDeCompra::whereMonth('fecha_envio', $currentMonth)->sum('monto');

        // Total clientes
        $totalClientes = Cliente::count();

        // Ventas mensuales (agrupadas por mes)
        $ventasMensuales = OrdenDeCompra::select(
            DB::raw('SUM(monto) as totalMonto'),
            DB::raw('MONTH(fecha_envio) as mes')
        )
        ->groupBy('mes')
        ->get();

        // Comparación de ventas del mes pasado y del mes en curso
        $mesPasado = Carbon::now()->subMonth()->month;
        $ventasMesPasado = OrdenDeCompra::whereMonth('fecha_envio', $mesPasado)->sum('monto');
        $ventasMesActual = $totalMontoMes;

        // Productos más vendidos
        $productosMasVendidos = OrdenDeCompra::select(
            'producto_id',
            DB::raw('SUM(unidades) as totalUnidades'),
            DB::raw('SUM(CASE WHEN MONTH(fecha_envio) = ' . $currentMonth . ' THEN unidades ELSE 0 END) as unidadesMes'),
            DB::raw('SUM(CASE WHEN estado_orden != "despachado" THEN unidades ELSE 0 END) as unidadesPorDespachar')
        )
        ->groupBy('producto_id')
        ->orderBy('totalUnidades', 'desc')
        ->take(5)
        ->with('producto') // Asegúrate de tener la relación producto en el modelo OrdenDeCompra
        ->get();

        // Pasar datos a la vista
        return view('dashboard', compact(
            'totalUnidadesMes',
            'totalMontoMes',
            'totalClientes',
            'ventasMensuales',
            'ventasMesPasado',
            'ventasMesActual',
            'productosMasVendidos'
        ));
    }

    private function formatNumber($number) {
        return number_format($number, 0, '', '.') . '.-';
    }
}
