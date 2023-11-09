<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EventoController;

Route::post('/reservas', [ReservaController::class, 'store']);

Route::get('/habitaciones',[HabitacionController::class, 'index']);
