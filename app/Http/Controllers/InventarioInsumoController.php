<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\InventarioInsumo;
use Illuminate\Http\Request;

class InventarioInsumoController extends Controller
{
    public function index()
    {
        $inventario = InventarioInsumo::with('insumo')->get();
        return view('logistica.inventario_insumos.index', compact('inventario'));
    }

    public function create()
    {
        $insumos = Insumo::all();
        return view('logistica.inventario_insumos.create', compact('insumos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|numeric|min:0', // Asegúrate de usar 'numeric' para permitir decimales
            'insumo_id' => 'required|exists:insumos,id',
        ]);
    
        // Guardar en la base de datos
        InventarioInsumo::create([
            'insumo_id' => $request->insumo_id,
            'cantidad' => $request->cantidad,
        ]);
    
        return redirect()->route('inventario_insumos.index')->with('success', 'Insumo asignado al inventario con éxito.');
    }


    public function edit($id)
    {
        $inventario = InventarioInsumo::find($id);
        return view('logistica.inventario_insumos.edit', compact('inventario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min=1',
        ]);

        $inventario = InventarioInsumo::find($id);
        $inventario->update($request->all());

        return redirect()->route('inventario_insumos.index')->with('success', 'Inventario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $inventario = InventarioInsumo::find($id);
        $inventario->delete();

        return redirect()->route('inventario_insumos.index')->with('success', 'Insumo eliminado del inventario.');
    }
}
