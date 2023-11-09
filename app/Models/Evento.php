<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'reserva_id'];

    // Relación con la reserva
    public function reserva()
{
    return $this->belongsTo('App\Models\Reserva');
}
}
