<?php

namespace App\Http\Controllers;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function index()
    {
        $habitaciones = Habitacion::all();
        return response()->json($habitaciones);
    }

}
