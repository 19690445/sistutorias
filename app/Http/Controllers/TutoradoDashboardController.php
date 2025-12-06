<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutoradoDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $estudiante = $user->estudiante; 

        $tutor = $estudiante ? $estudiante->tutor : null;

        return view('tutorado.dashboard', [
            'estudiante' => $estudiante,
            'tutor' => $tutor
        ]);
    }
}
