<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index()
    {
        $tutores = Tutor::all();
        return view('tutores.index', compact('tutores'));
    }
}
