<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chair extends Model
{
    use HasFactory;

    protected $fillable = [
        'row',
        'column',
        'state',
        'price',
    ];

    /**
     * Relación 1:1 con el modelo TemporalReserve
     *  - Una silla puede tener una reserva temporal.
     *  - Una reserva temporal pertenece a una silla específica.
     */
    public function temporalReserve()
    {
        return $this->hasOne(TemporalReserve::class);
    }

    /**
     * Relación N:1 con el modelo Room
     *  - Una silla pertenece a una sala.
     *  - Una sala tiene muchas sillas.
     */
    public function room()
    {
        return $this->hasOne(Room::class);
    }

    /**
     * Relación 1:N con el modelo OrderTicket
     *  - Una silla puede pertenecer a un ticket (horarios + sillas) de un pedido.
     */
    public function tickets()
    {
        return $this->hasMany(OrderTicket::class);
    }
}
