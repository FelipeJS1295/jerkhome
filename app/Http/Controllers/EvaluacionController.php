<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function index()
    {
        $evaluaciones = Evaluacion::with('trabajador')->get();
        return view('rrhh.evaluacion.index', compact('evaluaciones'));
    }

    public function create()
    {
        $trabajadores = Trabajador::all();
        return view('rrhh.evaluacion.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha' => 'required|date',
            'desempeño' => 'required|integer|min:1|max:5',
            'asistencia' => 'required|integer|min:1|max:5',
            'habilidades_tecnicas' => 'required|integer|min:1|max:5',
            'comunicacion' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
        ]);

        Evaluacion::create($request->all());

        return redirect()->route('evaluacion.index')->with('success', 'Evaluación registrada exitosamente.');
    }

    public function show(Evaluacion $evaluacion)
    {
        return view('rrhh.evaluacion.show', compact('evaluacion'));
    }

    public function edit(Evaluacion $evaluacion)
    {
        $trabajadores = Trabajador::all();
        return view('rrhh.evaluacion.edit', compact('evaluacion', 'trabajadores'));
    }

    public function update(Request $request, Evaluacion $evaluacion)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha' => 'required|date',
            'desempeño' => 'required|integer|min:1|max:5',
            'asistencia' => 'required|integer|min:1|max:5',
            'habilidades_tecnicas' => 'required|integer|min:1|max:5',
            'comunicacion' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
        ]);

        $evaluacion->update($request->all());

        return redirect()->route('evaluacion.index')->with('success', 'Evaluación actualizada exitosamente.');
    }

    public function destroy(Evaluacion $evaluacion)
    {
        $evaluacion->delete();

        return redirect()->route('evaluacion.index')->with('success', 'Evaluación eliminada exitosamente.');
    }
}
