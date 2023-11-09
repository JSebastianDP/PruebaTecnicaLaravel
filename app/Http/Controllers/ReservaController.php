<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Reserva;
use App\Events\ReservaRealizada;
use App\Mail\ConfirmacionReserva;
use Illuminate\Support\Facades\Queue;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        $reserva = null;
        try {
            \Log::info('Inicio del método store');

            // ... Tu código de validación y creación de reserva ...

            // Despacha el evento para procesar de forma asincrónica
            event(new ReservaRealizada($reserva));

            // Enviar trabajo a la cola para enviar el correo de confirmación
            Queue::push(function ($job) use ($reserva) {
                try {
                    \Log::info('Enviando correo de confirmación');
                    Mail::to($reserva->cliente_email)->send(new ConfirmacionReserva($reserva));
                } catch (\Exception $e) {
                    \Log::error('Error al enviar el correo de confirmación: ' . $e->getMessage());
                } finally {
                    $job->delete();
                }
            });

            \Log::info('Fin del método store');

            // Devolver respuesta JSON en caso de éxito
            return response()->json(['message' => 'Reserva realizada con éxito']);
        } catch (\Exception $e) {
            \Log::error('Error en el método store: ' . $e->getMessage());

            // Revertir la transacción en caso de error
            DB::rollBack();

            // Devolver respuesta JSON en caso de error
            return response()->json(['error' => 'Error al procesar la reserva'], 422);
        }
    }

}
