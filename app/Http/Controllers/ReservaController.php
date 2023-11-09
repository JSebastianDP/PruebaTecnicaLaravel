<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\ReservaRealizada;
use App\Http\Controllers\Controller;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            // Otros campos de validación según sea necesario
        ]);

        try {
            // Iniciar una transacción de base de datos
            DB::beginTransaction();

            // Obtener la reserva actualizada para el bloqueo optimista
            $reserva = Reserva::findOrFail($request->input('habitacion_id'));

            // Verificar si la versión coincide
            if ($reserva->version !== $request->input('version')) {
                throw new \Exception('Conflicto de concurrencia. La reserva ha sido modificada por otro usuario.');
            }

            // Actualizar la reserva (ejemplo)
            $reserva->update([
                // Actualiza otros campos según sea necesario
                'estado' => 'confirmada',
            ]);

            // Despachar el evento para procesar de forma asincrónica
            event(new ReservaRealizada($reserva));

            // Confirmar la transacción
            DB::commit();

            return response()->json(['message' => 'Reserva realizada con éxito']);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

}
