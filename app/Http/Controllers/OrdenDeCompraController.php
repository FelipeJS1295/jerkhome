<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenDeCompra;
use App\Models\Cliente;
use App\Models\Producto;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class OrdenDeCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = OrdenDeCompra::query();

        if ($request->filled('orden_de_compra')) {
            $query->where('orden_de_compra', 'like', '%' . $request->input('orden_de_compra') . '%');
        }

        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->input('cliente') . '%');
            });
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->input('fecha'));
        }

        $ordenes = $query->get();

        return view('ordenes_de_compra.index', compact('ordenes'));
    }

    public function updateEstadoMultiple(Request $request)
    {
        // Validar el nuevo estado
        $request->validate([
            'nuevo_estado' => 'required|in:nuevo,en proceso,terminado,despachado,devolucion',
            'ordenes' => 'required|array',
            'ordenes.*' => 'exists:orden_de_compras,id',
        ]);

        $nuevoEstado = $request->input('nuevo_estado');
        $ordenesIds = $request->input('ordenes');

        // Actualizar el estado de las órdenes seleccionadas
        OrdenDeCompra::whereIn('id', $ordenesIds)->update(['estado_orden' => $nuevoEstado]);

        return response()->json(['success' => true]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ordenes_de_compra.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'fecha' => 'required|date',
            'orden_de_compra' => 'required|string|max:255',
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'monto' => 'required|numeric',
            'fecha_envio' => 'required|date',
            'rut' => 'nullable|string|max:255',
            'nombre_cliente_final' => 'nullable|string|max:255',
        ]);

        OrdenDeCompra::create($request->all());

        return redirect()->route('ordenes-de-compra.index')
                        ->with('success', 'Orden de compra creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orden = OrdenDeCompra::findOrFail($id);
        return view('ordenes_de_compra.show', compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orden = OrdenDeCompra::findOrFail($id);
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ordenes_de_compra.edit', compact('orden', 'clientes', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        dd($request->all());

        $request->validate([
            'fecha' => 'required|date',
            'orden_de_compra' => 'required|string|max:255',
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'monto' => 'required|numeric',
            'fecha_envio' => 'required|date',
            'rut' => 'nullable|string|max:255',
            'nombre_cliente_final' => 'nullable|string|max:255',
        ]);

        $orden = OrdenDeCompra::findOrFail($id);
        $orden->update($request->all());

        return redirect()->route('ordenes-de-compra.index')
                        ->with('success', 'Orden de compra actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orden = OrdenDeCompra::findOrFail($id);
        $orden->delete();

        return redirect()->route('ordenes-de-compra.index')
            ->with('success', 'Orden de compra eliminada exitosamente.');
    }

    /**
     * Display the form for uploading orders in bulk.
     *
     * @return \Illuminate\Http\Response
     */
    public function showImportForm()
    {
        return view('ordenes_de_compra.import');
    }

    /**
     * Handle the bulk upload of orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function parseDate($value, $field, $rowIndex, &$errors)
    {
        if (is_numeric($value)) {
            try {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('d-m-Y');
            } catch (\Exception $e) {
                $errors[] = "Error al parsear fecha numérica en la fila $rowIndex, campo $field: " . $e->getMessage();
                return null;
            }
        }

        try {
            return Carbon::parse($value)->format('d-m-Y');
        } catch (\Exception $e) {
            $errors[] = "Error al parsear fecha de cadena en la fila $rowIndex, campo $field: " . $e->getMessage();
            return null;
        }
    }

    public function maestra()
    {
        // Obtener todas las órdenes de compra con relaciones y filtrar por estado
        $ordenes = OrdenDeCompra::with('cliente', 'producto')
            ->whereIn('estado_orden', ['nuevo', 'en proceso', 'terminado'])
            ->get();
    
        // Agrupar las órdenes por cliente, producto y fecha
        $clientesConOrdenes = $ordenes->groupBy('cliente_id')->map(function ($ordenesCliente) {
            return $ordenesCliente->groupBy('producto_id')->map(function ($ordenesProducto) {
                return $ordenesProducto->groupBy(function ($orden) {
                    return Carbon::parse($orden->fecha_envio)->format('d-m-Y');
                });
            });
        });
    
        // Obtener las fechas únicas y ordenarlas
        $fechas = $ordenes->pluck('fecha_envio')->map(function ($fecha) {
            return Carbon::parse($fecha)->format('Y-m-d');
        })->unique()->sort()->map(function ($fecha) {
            return Carbon::parse($fecha)->format('d-m-Y');
        });
    
        // Calcular totales por fecha
        $totalesPorFecha = $fechas->mapWithKeys(function ($fecha) use ($ordenes) {
            return [$fecha => $ordenes->filter(function ($orden) use ($fecha) {
                return Carbon::parse($orden->fecha_envio)->format('d-m-Y') === $fecha;
            })->sum('unidades')];
        });
    
        $totalGeneral = $ordenes->sum('unidades');
    
        return view('ordenes_de_compra.maestra', compact('clientesConOrdenes', 'fechas', 'totalesPorFecha', 'totalGeneral'));
    }
}
