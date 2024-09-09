<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insumo;
use App\Models\Proveedor;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::with('proveedor')->get(); // Asegúrate de cargar el proveedor
        return view('insumos.index', compact('insumos'));
    }

    public function create()
    {
        $proveedores = Proveedor::all(); // Obtén todos los proveedores de la tabla correcta
        return view('insumos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'sku_padre' => 'required|max:255',
            'sku_jerk' => 'required|max:255',
            'nombre' => 'required|max:255',
            'unidad_de_medida' => 'required|in:metros,unidades,centimetros,Kg,Lt',
            'precio_unitario' => 'required|numeric|min:0',
        ]);
    
        // Depuración de datos recibidos
        // dd($request->all());
    
        Insumo::create($validatedData);
    
        return redirect()->route('insumos.index')->with('success', 'Insumo creado exitosamente.');
    }
}