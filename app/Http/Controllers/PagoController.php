<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Pago;

class PagoController extends Controller
{
    public function store(Request $request, $id)
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

        $documento->pagado = ($documento->total - ($montoPagado + $request->monto_pago)) <= 0;
        $documento->save();

        return redirect()->route('documentos.mostrarPago', $documento->id)->with('success', 'Pago registrado correctamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $documento_id = $pago->documento_id;
        $pago->delete();

        // Actualizar el estado del documento si es necesario
        $documento = Documento::findOrFail($documento_id);
        $montoPagado = $documento->pagos()->sum('monto');
        $documento->pagado = ($documento->total - $montoPagado) <= 0;
        $documento->save();

        return redirect()->route('documentos.historial', $documento_id)->with('success', 'Pago eliminado correctamente.');
    }
}
