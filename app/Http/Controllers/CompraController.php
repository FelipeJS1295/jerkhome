<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Insumo;
use App\Models\Proveedor;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('insumos')->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $insumos = Insumo::all();
        return view('compras.create', compact('proveedores', 'insumos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'factura_o_boleta' => 'required|string|max:255',
            'proveedor_id' => 'required|exists:proveedores,id',
            'insumo.*.insumo_id' => 'required|exists:insumos,id',
            'insumo.*.cantidad' => 'required|numeric|min:0',
            'insumo.*.precio_unitario' => 'required|numeric|min:0',
            'insumo.*.total' => 'required|numeric|min:0',
        ]);
    
        $compra = Compra::create([
            'fecha' => $request->input('fecha'),
            'fecha_vencimiento' => $request->input('fecha_vencimiento'),
            'factura_o_boleta' => $request->input('factura_o_boleta'),
            'proveedor_id' => $request->input('proveedor_id'),
            'estado' => 'Ingresada', // Default state
        ]);
    
        foreach ($request->input('insumo') as $insumo) {
            $compra->insumos()->attach($insumo['insumo_id'], [
                'cantidad' => $insumo['cantidad'],
                'precio_unitario' => $insumo['precio_unitario'],
                'total' => $insumo['total'],
            ]);
        }
    
        return redirect()->route('compras.index')->with('success', 'Compra creada exitosamente.');
    }
}
