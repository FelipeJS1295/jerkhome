<?php

namespace App\Http\Controllers;

use App\Models\TiempoPersonal;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class TiempoPersonalController extends Controller
{
    public function index()
    {
        $tiempos_personales = TiempoPersonal::with('trabajador')->get();
        return view('rrhh.tiempo_personal.index', compact('tiempos_personales'));
    }

    public function create()
    {
        $trabajadores = Trabajador::all();
        return view('rrhh.tiempo_personal.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'tipo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
        ]);

        TiempoPersonal::create($request->all());

        return redirect()->route('tiempo_personal.index')->with('success', 'Tiempo personal agregado exitosamente.');
    }

    public function edit(TiempoPersonal $tiempoPersonal)
    {
        $trabajadores = Trabajador::all();
        return view('rrhh.tiempo_personal.edit', compact('tiempoPersonal', 'trabajadores'));
    }

    public function update(Request $request, TiempoPersonal $tiempoPersonal)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'tipo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
        ]);

        $tiempoPersonal->update($request->all());

        return redirect()->route('tiempo_personal.index')->with('success', 'Tiempo personal actualizado exitosamente.');
    }

    public function destroy(TiempoPersonal $tiempoPersonal)
    {
        $tiempoPersonal->delete();

        return redirect()->route('tiempo_personal.index')->with('success', 'Tiempo personal eliminado exitosamente.');
    }
}