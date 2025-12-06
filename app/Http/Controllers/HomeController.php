<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard or redirect by role.
     */
    public function index()
    {
        $user = Auth::user();

        
        if (!$user->rol) {
            return redirect()->route('home')->with('error', 'Tu cuenta no tiene un rol asignado.');
        }

        
        switch ($user->rol->nombre) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'docente':
                return redirect()->route('docente.dashboard');
            case 'coordinador':
                return redirect()->route('coordinador.dashboard');
            case 'tutorado':
            default:
                return view('home'); 
        }
    }
}
