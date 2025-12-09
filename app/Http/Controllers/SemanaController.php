<?php

namespace App\Http\Controllers;

use App\Models\Semana;
use Illuminate\Http\Request;

class SemanaController extends Controller
{
    public function index()
    {
        $semanas = Semana::orderBy('id')->get();
        return view('semanas.index', compact('semanas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Semana::create(['nombre' => $request->nombre]);

        return redirect()->back()->with('success', 'Semana agregada correctamente');
    }

    public function edit(Semana $semana)
    {
        return view('semanas.edit', compact('semana'));
    }

    public function update(Request $request, Semana $semana)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $semana->update(['nombre' => $request->nombre]);

        return redirect()->route('semanas.index')->with('success', 'Semana actualizada correctamente');
    }

    public function destroy(Semana $semana)
    {
        $semana->delete();
        return redirect()->back()->with('success', 'Semana eliminada correctamente');
    }
}
