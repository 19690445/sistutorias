<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Tutorado;
use App\Models\Sesion;
use App\Models\Reporte;

class TutorDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.tutor', [
            'totalTutorados' => Tutorado::count(),
            'totalSesiones' => Sesion::count(),
            'totalReportes' => Reporte::count(),
            'tutoresActivos' => Tutor::where('estado', 'activo')->count(),
        ]);
    }
}
