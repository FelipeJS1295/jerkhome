<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Transaccion;
use Illuminate\Http\Request;

class ContabilidadController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::all();
        $transacciones = Transaccion::with('cuenta')->get();
        return view('finanzas.contabilidad.index', compact('cuentas', 'transacciones'));
    }

    public function create()
    {
        $cuentas = Cuenta::all();
        return view('finanzas.contabilidad.create', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cuenta_id' => 'required|exists:cuentas,id',
            'tipo' => 'required|in:ingreso,gasto,transferencia',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        Transaccion::create($request->all());
        return redirect()->route('contabilidad.index')->with('success', 'Transacción registrada exitosamente.');
    }
}
