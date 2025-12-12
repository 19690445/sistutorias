<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index ()
    {
        $configuracion = Configuracion::first();
        return view ('admin.configuracion.index', compact('configuracion')); 
    }
}
