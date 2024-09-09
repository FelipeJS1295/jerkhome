<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\TiempoPersonal;
use App\Models\Evaluacion;
use App\Models\OrdenDeTrabajo;
use App\Models\Producto;
use Carbon\Carbon;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajador::all();
        return view('trabajadores.index', compact('trabajadores'));
    }

    public function create()
    {
        return view('trabajadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|max:12|unique:personal,rut',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:personal,email',
            'afp' => 'required|string|max:255',
            'isapre_fonasa' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'sueldo' => 'required|numeric',
            'fecha_ingreso' => 'required|date',
        ]);

        Trabajador::create($request->all());
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador creado exitosamente.');
    }

    public function edit($id)
    {
        $trabajador = Trabajador::find($id);
        return view('trabajadores.edit', compact('trabajador'));
    }

    public function update(Request $request, $id)
    {
        $trabajador = Trabajador::find($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|max:12|unique:personal,rut,' . $trabajador->id,
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:personal,email,' . $trabajador->id,
            'afp' => 'required|string|max:255',
            'isapre_fonasa' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'sueldo' => 'required|numeric',
            'fecha_ingreso' => 'required|date',
        ]);

        $trabajador->update($request->all());

        return redirect()->route('trabajadores.index')->with('success', 'Trabajador actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $trabajador = Trabajador::find($id);
        $trabajador->delete();

        return redirect()->route('trabajadores.index')->with('success', 'Trabajador eliminado exitosamente.');
    }

    public function show($id, Request $request)
    {
        $trabajador = Trabajador::with(['tiemposPersonales', 'evaluaciones'])->find($id);

        $fecha_desde = $request->input('fecha_desde') ? Carbon::parse($request->input('fecha_desde')) : Carbon::now()->subMonth()->day(26);
        $fecha_hasta = $request->input('fecha_hasta') ? Carbon::parse($request->input('fecha_hasta')) : Carbon::now()->day(25);

        $producciones = OrdenDeTrabajo::where('trabajador_id', $id)
            ->whereBetween('fecha', [$fecha_desde, $fecha_hasta])
            ->when($request->filled('numero_ot'), function ($query) use ($request) {
                $query->where('numero_ot', $request->numero_ot);
            })
            ->with('producto')
            ->get();

        $totalProduccion = 0;
        $totalUnidades = $producciones->count();

        foreach ($producciones as $produccion) {
            $producto = $produccion->producto;
            if ($trabajador->cargo == 'Tapicero') {
                $totalProduccion += $producto->ctapiceria;
            } elseif ($trabajador->cargo == 'Costura') {
                $totalProduccion += $producto->ccostura;
            } elseif ($trabajador->cargo == 'Cortador') {
                $totalProduccion += $producto->ccorte;
            } elseif ($trabajador->cargo == 'Armador') {
                $totalProduccion += $producto->carmado;
            } elseif ($trabajador->cargo == 'Esqueletero') {
                $totalProduccion += $producto->ccompleto;
            }
        }

        return view('trabajadores.show', compact('trabajador', 'producciones', 'totalProduccion', 'totalUnidades', 'fecha_desde', 'fecha_hasta'));
    }

    public function imprimirProduccion($id, Request $request)
    {
        $trabajador = Trabajador::findOrFail($id);

        $fecha_desde = $request->input('fecha_desde') ? Carbon::parse($request->input('fecha_desde')) : Carbon::now()->subMonth()->day(26);
        $fecha_hasta = $request->input('fecha_hasta') ? Carbon::parse($request->input('fecha_hasta')) : Carbon::now()->day(25);

        $producciones = OrdenDeTrabajo::where('trabajador_id', $id)
            ->whereBetween('fecha', [$fecha_desde, $fecha_hasta])
            ->when($request->filled('numero_ot'), function ($query) use ($request) {
                $query->where('numero_ot', $request->numero_ot);
            })
            ->with('producto')
            ->orderBy('fecha', 'asc')  // Ordenar por fecha ascendente
            ->get();

        $totalProduccion = 0;
        $totalUnidades = $producciones->count();

        foreach ($producciones as $produccion) {
            $producto = $produccion->producto;
            if ($trabajador->cargo == 'Tapicero') {
                $totalProduccion += $producto->ctapiceria;
            } elseif ($trabajador->cargo == 'Costura') {
                $totalProduccion += $producto->ccostura;
            } elseif ($trabajador->cargo == 'Cortador') {
                $totalProduccion += $producto->ccorte;
            } elseif ($trabajador->cargo == 'Armador') {
                $totalProduccion += $producto->carmado;
            } elseif ($trabajador->cargo == 'Esqueletero') {
                $totalProduccion += $producto->ccompleto;
            }
        }

        // Pasar los costos como enteros y formatear las fechas
        foreach ($producciones as $produccion) {
            $produccion->fecha = Carbon::parse($produccion->fecha)->format('d/m/Y');
        }

        return view('trabajadores.produccion_print', compact('trabajador', 'producciones', 'totalProduccion', 'totalUnidades'));
    }
}
