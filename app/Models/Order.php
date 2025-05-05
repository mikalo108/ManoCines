<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderTicket;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'subtotal',
        'total',
    ];

    /**
     * Relación 1:N con el modelo User
     *  - Un pedido pertenece a un usuario.
     *  - Un usuario puede tener muchos pedidos.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación 1:N con el modelo OrderTicket
     *  - Un pedido puede tener muchos tickets.
     *  - Un ticket pertenece a un pedido.
     */
    public function tickets()
    {
        return $this->hasMany(OrderTicket::class);
    }

    /**
     * Relación 1:N con el modelo Product
     *  - Un pedido puede tener muchos productos.
     *  - Un producto pertenece a un pedido.
     */
    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
