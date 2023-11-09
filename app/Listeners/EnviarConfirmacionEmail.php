<?php

namespace App\Listeners;
use App\Events\ReservaRealizada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionReserva;

class EnviarConfirmacionEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ReservaRealizada $event)
    {
        $reserva = $event->reserva;
        
        try {
            // Envía el correo de confirmación usando la Mailable ConfirmacionReserva
            Mail::to($reserva->cliente_email)->send(new ConfirmacionReserva($reserva));
            
            // Se devuelve una respuesta JSON indicando el éxito
            return response()->json(['message' => 'Correo de confirmación enviado con éxito']);
        } catch (\Exception $e) {
            // Puedes devolver una respuesta JSON indicando el error
            return response()->json(['error' => 'Error al enviar el correo de confirmación'], 500);
        }
    }
}