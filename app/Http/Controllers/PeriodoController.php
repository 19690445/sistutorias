<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin,coordinador']);
    }

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
            'nombre_periodo' => 'required|string|max:50',
            'año_periodo' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo,finalizado',
        ]);

        Periodo::create($request->all());

        return redirect()->route('periodos.index')
                         ->with('success', 'Periodo creado correctamente.');
    }

    public function edit(Periodo $periodo)
    {
        return view('periodos.edit', compact('periodo'));
    }

    public function update(Request $request, Periodo $periodo)
    {
        $request->validate([
            'nombre_periodo' => 'required|string|max:50',
            'año_periodo' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo,finalizado',
        ]);

        $periodo->update($request->all());

        return redirect()->route('periodos.index')
                         ->with('success', 'Periodo actualizado correctamente.');
    }

    public function destroy(Periodo $periodo)
    {
        $periodo->delete();
        return redirect()->route('periodos.index')
                         ->with('success', 'Periodo eliminado correctamente.');
    }
}
