<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = ['habitacion_id', 'version'];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }}
