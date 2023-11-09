<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $fillable = ['nombre', 'disponibilidad'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
