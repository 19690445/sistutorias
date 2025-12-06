<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorado;
use Illuminate\Support\Facades\Auth;

class TutoradoController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $tutorado = Tutorado::where('users_id', $user->id)->first();

         
        if (!$tutorado) {
            return view('tutorado.dashboard')->with('tutorado', null);
        }

        return view('tutorado.dashboard', compact('tutorado'));
    }
}
