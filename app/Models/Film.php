<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Time;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'overview',
        'trailer',
    ];

    /**
     * Relación 1:N con el modelo Time
     *  - Una película puede tener muchos horarios.
     *  - Un horario pertenece a una película.
     */
    public function times()
    {
        return $this->hasMany(Time::class);
    }

    /**
     * Relación con pedidos a través de tickets
     * Un film puede estar en muchos pedidos a través de tickets
     */
    public function orders()
    {
        return $this->belongsToMany(
            \App\Models\Order::class,
            'orders_tickets',
            'time_id', // Foreign key on orders_tickets table for Time
            'order_id' // Foreign key on orders_tickets table for Order
        )->using(\App\Models\OrderTicket::class)
         ->withTimestamps()
         ->wherePivotIn('time_id', function ($query) {
             $query->select('id')
                   ->from('times')
                   ->where('film_id', $this->id);
         });
    }
}
