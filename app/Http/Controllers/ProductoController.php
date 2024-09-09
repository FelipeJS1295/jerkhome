<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:productos',
            'nombre' => 'required',
            'esqueletoc' => 'nullable|string',
            'esqueletoa' => 'nullable|string',
            'esqueleto' => 'nullable|string',
            'ccostura' => 'nullable|integer',
            'ctapiceria' => 'nullable|integer',
            'ccorte' => 'nullable|integer',
            'carmado' => 'nullable|integer',
            'ccompleto' => 'nullable|integer',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $producto = Producto::find($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sku' => 'required|unique:productos,sku,' . $id,
            'nombre' => 'required',
            'esqueletoc' => 'nullable|string',
            'esqueletoa' => 'nullable|string',
            'esqueleto' => 'nullable|string',
            'ccostura' => 'nullable|integer',
            'ctapiceria' => 'nullable|integer',
            'ccorte' => 'nullable|integer',
            'carmado' => 'nullable|integer',
            'ccompleto' => 'nullable|integer',
        ]);

        $producto = Producto::find($id);
        $producto->update($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        Producto::find($id)->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}

