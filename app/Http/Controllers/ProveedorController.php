<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|unique:proveedors|max:255',
            'nombre' => 'required|max:255',
            'contacto' => 'required|max:255',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }
    
    public function verDeuda($rut)
    {
        $proveedor = Proveedor::where('rut', $rut)->first();
    
        if (!$proveedor) {
            abort(404, 'Proveedor no encontrado');
        }
    
        $documentos = $proveedor->documentos;
        $pagos = Pago::whereIn('documento_id', $documentos->pluck('id'))->get();
    
        $totalDeuda = $documentos->sum('total');
        $totalPagos = $pagos->sum('monto');
    
        return view('proveedores.deuda', compact('proveedor', 'documentos', 'pagos', 'totalDeuda', 'totalPagos'));
    }
}
