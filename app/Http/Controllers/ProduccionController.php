<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenDeTrabajo;
use App\Models\Trabajador;
use App\Models\Producto;

class ProduccionController extends Controller
{
    public function index(Request $request)
    {
        $query = OrdenDeTrabajo::with('trabajador', 'producto');
    
        if ($request->has('trabajador_id') && $request->trabajador_id) {
            $query->where('trabajador_id', $request->trabajador_id);
        }
    
        $ordenesTrabajo = $query->get();
        $trabajadores = Trabajador::all();
    
        return view('produccion.index', compact('ordenesTrabajo', 'trabajadores'));
    }

    public function create(Request $request)
    {
        $seccion = $request->input('seccion');
        $trabajadores = Trabajador::all();
        $productos = Producto::all();

        switch ($seccion) {
            case 'Tapiceria':
                $trabajadores = Trabajador::where('cargo', 'Tapicero')->get();
                $productos = Producto::select('id', 'nombre')->get();
                break;
            case 'Costura':
                $trabajadores = Trabajador::where('cargo', 'Costura')->get();
                $productos = Producto::select('id', 'nombre')->get();
                break;
            case 'Esqueleteria Corte':
                $trabajadores = Trabajador::where('cargo', 'Esqueleteria')->get();
                $productos = Producto::select('id', 'esqueletoc as nombre')->get();
                break;
            case 'Esqueleteria Armado':
                $trabajadores = Trabajador::where('cargo', 'Esqueleteria')->get();
                $productos = Producto::select('id', 'esqueletoa as nombre')->get();
                break;
            case 'Esqueleteria Completo':
                $trabajadores = Trabajador::where('cargo', 'Esqueleteria')->get();
                $productos = Producto::select('id', 'esqueleto as nombre')->get();
                break;
        }

        return view('produccion.create', compact('seccion', 'trabajadores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_ot' => 'required',
            'fecha' => 'required|date',
            'seccion' => 'required',
            'trabajador_id' => 'required|exists:personal,id',
            'producto_id' => 'required|exists:productos,id',
        ]);

        // Verificar si ya existen dos entradas con el mismo número de orden
        $existingOrders = OrdenDeTrabajo::where('numero_ot', $request->numero_ot)->count();

        if ($existingOrders >= 2) {
            return redirect()->route('produccion.create', ['seccion' => $request->seccion])
                            ->withErrors(['numero_ot' => 'El número de OT ya ha sido ingresado en dos secciones.']);
        }

        OrdenDeTrabajo::create($request->all());

        return redirect()->route('produccion.create', ['seccion' => $request->seccion])
                        ->with('success', 'Orden de Trabajo creada exitosamente.');
    }

    public function edit($id)
    {
        $orden = OrdenDeTrabajo::find($id);
        $trabajadores = Trabajador::where('cargo', $orden->seccion)->get();
        $productos = Producto::all();
        return view('produccion.edit', compact('orden', 'trabajadores', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_ot' => 'required',
            'fecha' => 'required|date',
            'seccion' => 'required',
            'trabajador_id' => 'required|exists:personal,id',
            'producto_id' => 'required|exists:productos,id',
        ]);

        // Validar que el número de OT no se repita más de dos veces
        $count = OrdenDeTrabajo::where('numero_ot', $request->numero_ot)
                                ->where('id', '!=', $id)
                                ->count();
        if ($count >= 2) {
            return redirect()->back()->withErrors(['numero_ot' => 'El número de OT ya ha sido ingresado dos veces.'])->withInput();
        }

        $orden = OrdenDeTrabajo::find($id);
        $orden->update($request->all());
        return redirect()->route('produccion.index')->with('success', 'Orden de Trabajo actualizada exitosamente.');
    }

    public function destroy($id)
    {
        OrdenDeTrabajo::find($id)->delete();
        return redirect()->route('produccion.index')->with('success', 'Orden de Trabajo eliminada exitosamente.');
    }
}
