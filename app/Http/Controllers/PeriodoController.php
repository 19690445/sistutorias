<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;

class PeriodoController extends Controller
{
    
    public function index()
    {
        $periodos = Periodo::all();
        return view('periodos.index', compact('periodos'));
    }

   
    public function create()
    {
        return view('periodos.create');
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'nombre_periodo' => 'required|string|max:100',
            'año_periodo' => 'required|integer',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Periodo::create($request->all());

        
        $rolePrefix = auth()->user()->role->nombre; 
        return redirect()->route($rolePrefix.'.periodos.index')
                         ->with('success', 'Periodo creado correctamente.');
    }

    public function show($id)
    {
        $periodo = Periodo::findOrFail($id);
        return view('periodos.show', compact('periodo'));
    }

    public function edit($id)
    {
        $periodo = Periodo::findOrFail($id);
        return view('periodos.edit', compact('periodo'));
    }

    
    public function update(Request $request, $id)
    {
        $periodo = Periodo::findOrFail($id);

        $request->validate([
            'nombre_periodo' => 'required|string|max:100',
            'año_periodo' => 'required|integer',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $periodo->update($request->all());

        $rolePrefix = auth()->user()->role->nombre;
        return redirect()->route($rolePrefix.'.periodos.index')
                         ->with('success', 'Periodo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $periodo = Periodo::findOrFail($id);
        $periodo->delete();

        $rolePrefix = auth()->user()->role->nombre;
        return redirect()->route($rolePrefix.'.periodos.index')
                         ->with('success', 'Periodo eliminado correctamente.');
    }
}
