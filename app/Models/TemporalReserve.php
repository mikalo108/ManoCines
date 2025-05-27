<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporalReserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'chair_id',
        'reserve_time',
    ];

    /**
     * Relación 1:1 con el modelo Chair
     *  -   Un registro de reserva temporal pertenece a una silla específica.
     *  -   Se utiliza para obtener la silla asociada a la reserva temporal.
     *  -   Esta reserva temporal bloqueará la silla para el tiempo especificado.
     */
    public function chair()
    {
        return $this->belongsTo(Chair::class);
    }
}
