<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class OrderTicket extends Model
{
    use HasFactory;

    protected $table = 'orders_tickets';

    protected $fillable = [
        'order_id',
        'chair_id',
        'time_id',
    ];

    /**
     * Relación 1:N con el modelo Order
     *  - Una silla reservada y un horario pertenecen a un pedido.
     *  - Un pedido puede tener muchas sillas reservadas y muchos horarios.
     *  - El pedido es único, pero puede tener muchas sillas reservadas y horarios. Ahora, esta combinación de silla y horario son únicos para ese pedido, es decir, una silla puede estar en otro pedido con otro horario pero no con el mismo y el el caso de horario, lo mismo.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación 1:N con el modelo Chair
     *  - Una silla reservada y un horario pertenecen a un pedido.
     *  - Un pedido puede tener muchas sillas reservadas y muchos horarios.
     *  - El pedido es único, pero puede tener muchas sillas reservadas y horarios. Ahora, esta combinación de silla y horario son únicos para ese pedido, es decir, una silla puede estar en otro pedido con otro horario pero no con el mismo y el el caso de horario, lo mismo.
     */
    public function chair()
    {
        return $this->belongsTo(Chair::class);
    }

    /**
     * Relación 1:N con el modelo Time
     *  - Una silla reservada y un horario pertenecen a un pedido.
     *  - Un pedido puede tener muchas sillas reservadas y muchos horarios.
     *  - El pedido es único, pero puede tener muchas sillas reservadas y horarios. Ahora, esta combinación de silla y horario son únicos para ese pedido, es decir, una silla puede estar en otro pedido con otro horario pero no con el mismo y el el caso de horario, lo mismo.
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
