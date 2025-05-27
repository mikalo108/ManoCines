<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cinema;
use App\Models\Room;

class CinemaRoom extends Model
{
    use HasFactory;

    protected $table = 'cinemas_rooms';

    protected $fillable = [
        'cinema_id',
        'room_id',
    ];

    /**
     * Relación 1:N con el modelo Cinema
     *  - Una sala pertenece a un cine.
     *  - Un cine puede tener muchas salas.
     */
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * Relación 1:N con el modelo Room
     *  - Una sala pertenece a un cine.
     *  - Un cine puede tener muchas salas.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
