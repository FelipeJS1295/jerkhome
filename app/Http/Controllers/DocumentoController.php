<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Proveedor;
use App\Models\Pago;
use Carbon\Carbon;

class DocumentoController extends Controller
{
    public function index(Request $request)
{
    $query = Documento::query();
    $proveedores = Proveedor::all();

    if ($request->has('numero_documento')) {
        $query->where('numero_documento', 'like', '%' . $request->numero_documento . '%');
    }

    if ($request->has('proveedor_id')) {
        $query->where('proveedor_id', $request->proveedor_id);
    }

    if ($request->has('fecha_documento')) {
        $query->where('fecha_documento', $request->fecha_documento);
    }

    if ($request->has('vencimiento')) {
        $query->where('vencimiento', $request->vencimiento);
    }

    if ($request->has('estado')) {
        if ($request->estado == 'pagados') {
            $query->where('pagado', true);
        } elseif ($request->estado == 'no_pagados') {
            $query->where('pagado', false);
        }
    }

    $documentos = $query->with('proveedor')->paginate(10);

    foreach ($documentos as $documento) {
        $hoy = Carbon::now();
        $vencimiento = Carbon::parse($documento->vencimiento);
        $diasRestantes = $hoy->diffInDays($vencimiento, false);

        if ($diasRestantes > 0) {
            $documento->estado = "Faltan " . round($diasRestantes) . " días";
            $documento->estado_color = 'orange';
        } elseif ($diasRestantes == 0) {
            $documento->estado = "Pagar hoy";
            $documento->estado_color = 'yellow';
        } else {
            $documento->estado = abs($diasRestantes) . " días de atraso";
            $documento->estado_color = 'red';
        }
    }

    return view('finanzas.documentos.index', compact('documentos', 'proveedores'));
}

    public function registrarPago(Request $request, $id)
    {
        $request->validate([
            'tipo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
            'numero_pago' => 'required|string',
            'monto_pago' => 'required|numeric|min:0',
            'cuotas' => 'nullable|integer|min:1',
        ]);

        $documento = Documento::findOrFail($id);
        $montoPagado = $documento->pagos->sum('monto');

        if ($request->cuotas && $request->cuotas > 1) {
            $cuotaMonto = $request->monto_pago / $request->cuotas;
            for ($i = 0; $i < $request->cuotas; $i++) {
                $documento->pagos()->create([
                    'tipo_pago' => $request->tipo_pago,
                    'fecha_pago' => $request->fecha_pago,
                    'numero_pago' => $request->numero_pago,
                    'monto' => $cuotaMonto,
                ]);
            }
        } else {
            $documento->pagos()->create([
                'tipo_pago' => $request->tipo_pago,
                'fecha_pago' => $request->fecha_pago,
                'numero_pago' => $request->numero_pago,
                'monto' => $request->monto_pago,
            ]);
        }

        $totalPagado = $documento->pagos->sum('monto');
        $documento->total_restante = $documento->total - $totalPagado;
        $documento->pagado = ($documento->total_restante <= 0);
        $documento->save();

        return redirect()->route('documentos.historial', $documento->id)->with('success', 'Pago registrado correctamente.');
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('finanzas.documentos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_documento' => 'required|unique:documentos|max:255',
            'proveedor_id' => 'required',
            'fecha_documento' => 'required|date',
            'vencimiento' => 'required|date',
            'monto_neto' => 'required|numeric',
        ]);

        $monto_neto = $request->input('monto_neto');
        $iva = $monto_neto * 0.19;
        $total = $monto_neto + $iva;

        $documento = Documento::create([
            'numero_documento' => $request->input('numero_documento'),
            'proveedor_id' => $request->input('proveedor_id'),
            'fecha_documento' => $request->input('fecha_documento'),
            'vencimiento' => $request->input('vencimiento'),
            'monto_neto' => $monto_neto,
            'iva' => $iva,
            'total' => $total,
            'total_restante' => $total, // Inicialmente, el total restante es igual al total
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento creado exitosamente.');
    }

    public function edit($id)
    {
        $documento = Documento::findOrFail($id);
        $proveedores = Proveedor::all();
        return view('finanzas.documentos.edit', compact('documento', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_documento' => 'required|max:255|unique:documentos,numero_documento,' . $id,
            'proveedor_id' => 'required',
            'fecha_documento' => 'required|date',
            'vencimiento' => 'required|date',
            'monto_neto' => 'required|numeric',
        ]);

        $documento = Documento::findOrFail($id);

        $monto_neto = $request->input('monto_neto');
        $iva = $monto_neto * 0.19;
        $total = $monto_neto + $iva;

        $documento->update([
            'numero_documento' => $request->input('numero_documento'),
            'proveedor_id' => $request->input('proveedor_id'),
            'fecha_documento' => $request->input('fecha_documento'),
            'vencimiento' => $request->input('vencimiento'),
            'monto_neto' => $monto_neto,
            'iva' => $iva,
            'total' => $total,
            'total_restante' => $total - $documento->pagos->sum('monto'), // Actualizar el total restante
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);
        if ($documento->pagos->count() > 0) {
            return redirect()->route('documentos.index')->with('error', 'No se puede eliminar un documento con pagos registrados.');
        }
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado exitosamente.');
    }

    public function corregir($id)
    {
        $documento = Documento::findOrFail($id);
        $documento->pagado = false;
        $documento->save();

        return redirect()->route('documentos.index')->with('success', 'El estado del documento ha sido corregido exitosamente.');
    }

    public function mostrarPago($id)
    {
        $documento = Documento::findOrFail($id);
        return view('finanzas.documentos.pagar', compact('documento'));
    }

    public function historial($id)
    {
        $documento = Documento::with('pagos')->findOrFail($id);
        return view('finanzas.documentos.historial', compact('documento'));
    }

    public function historialPagos($id)
    {
        $documento = Documento::with('pagos')->findOrFail($id);
        $totalPagado = $documento->pagos->sum('monto');
        return view('finanzas.documentos.historial', compact('documento', 'totalPagado'));
    }

    public function finalizar($id)
    {
        $documento = Documento::findOrFail($id);
        $documento->pagado = true;
        $documento->save();

        return redirect()->route('documentos.historial', $documento->id)->with('success', 'Documento marcado como pagado.');
    }

}
