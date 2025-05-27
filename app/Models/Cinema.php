<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\Product;

class Cinema extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'description',
    ];

    /**
     * Relación 1:N con el modelo Room
     *  - Un cine puede tener muchas salas.
     *  - Una sala pertenece a un cine.
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'cinemas_rooms');
    }

    /**
     * Relación N:N con el modelo Product
     *  - Un cine puede tener muchos productos.
     *  - Un producto pertenece a un cine.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_cinema');
    }

    /**
     * Relación N:1 con el modelo City
     *  - Un cine puede estar en muchas ciudades.
     *  - Una ciudad puede tener muchos cines.
     */
    public function cities()
    {
        return $this->belongsToMany(City::class, 'city_cinema');
    }
}
