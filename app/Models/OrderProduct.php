<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'note',
    ];

    /**
     * Relación 1:N con el modelo Order
     *  - Un producto pertenece a un pedido.
     *  - Un pedido puede tener muchos productos.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación 1:N con el modelo Product
     *  - Un producto pertenece a un pedido.
     *  - Un pedido puede tener muchos productos.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
